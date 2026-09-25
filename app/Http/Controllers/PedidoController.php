<?php

/**
 * Autor: Juan David Bedoya
 * Pedidos del cliente autenticado (con sus detalles de videojuegos y tarjetas).
 */

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Tarjeta;
use App\Models\VideoJuego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::withCount('detalles')
            ->where('usuario_id', Auth::id())
            ->latest('fecha')
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create(Request $request)
    {
        $videojuegos = VideoJuego::where('stock', '>', 0)->orderBy('titulo')->get();
        $tarjetas = Tarjeta::where('stock', '>', 0)->orderBy('nombre')->get();

        // Permite preseleccionar un videojuego desde su ficha (?videojuego=ID)
        $preseleccionado = (int) $request->query('videojuego');

        return view('pedidos.create', compact('videojuegos', 'tarjetas', 'preseleccionado'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'videojuegos' => ['nullable', 'array'],
            'videojuegos.*' => ['nullable', 'integer', 'min:0', 'max:10'],
            'tarjetas' => ['nullable', 'array'],
            'tarjetas.*' => ['nullable', 'integer', 'min:0', 'max:10'],
        ]);

        // Solo nos quedamos con los productos que tienen cantidad > 0
        $cantVideojuegos = array_filter($validated['videojuegos'] ?? [], fn ($c) => (int) $c > 0);
        $cantTarjetas = array_filter($validated['tarjetas'] ?? [], fn ($c) => (int) $c > 0);

        if (empty($cantVideojuegos) && empty($cantTarjetas)) {
            throw ValidationException::withMessages([
                'productos' => __('messages.pedido_vacio'),
            ]);
        }

        $pedido = DB::transaction(function () use ($cantVideojuegos, $cantTarjetas) {
            // lockForUpdate evita vender más stock del que hay si dos pedidos llegan a la vez
            $videojuegos = VideoJuego::whereIn('id', array_keys($cantVideojuegos))->lockForUpdate()->get()->keyBy('id');
            $tarjetas = Tarjeta::whereIn('id', array_keys($cantTarjetas))->lockForUpdate()->get()->keyBy('id');

            $lineas = [];

            foreach ($cantVideojuegos as $id => $cantidad) {
                $videojuego = $videojuegos->get($id);
                $this->verificarStock($videojuego, (int) $cantidad, $videojuego?->titulo);
                $lineas[] = ['producto' => $videojuego, 'campo' => 'videojuego_id', 'cantidad' => (int) $cantidad];
            }

            foreach ($cantTarjetas as $id => $cantidad) {
                $tarjeta = $tarjetas->get($id);
                $this->verificarStock($tarjeta, (int) $cantidad, $tarjeta?->nombre);
                $lineas[] = ['producto' => $tarjeta, 'campo' => 'tarjeta_id', 'cantidad' => (int) $cantidad];
            }

            $pedido = Pedido::create([
                'usuario_id' => Auth::id(),
                'fecha' => now(),
                'estado' => 'pendiente',
                'total' => 0,
            ]);

            $total = 0;

            foreach ($lineas as $linea) {
                $producto = $linea['producto'];

                $pedido->detalles()->create([
                    $linea['campo'] => $producto->id,
                    'cantidad' => $linea['cantidad'],
                    'precio_unit' => $producto->precio,
                ]);

                $producto->decrement('stock', $linea['cantidad']);
                $total += $producto->precio * $linea['cantidad'];
            }

            $pedido->update(['total' => $total]);

            return $pedido;
        });

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', __('messages.pedido_created'));
    }

    public function show(Pedido $pedido)
    {
        $this->autorizar($pedido);

        $pedido->load('detalles.videojuego', 'detalles.tarjeta');

        return view('pedidos.show', compact('pedido'));
    }

    public function cancelar(Pedido $pedido)
    {
        $this->autorizar($pedido);

        if ($pedido->estado !== 'pendiente') {
            return back()->with('error', __('messages.pedido_no_cancelable'));
        }

        DB::transaction(function () use ($pedido) {
            // Devolvemos el stock de cada producto
            foreach ($pedido->detalles as $detalle) {
                $detalle->videojuego?->increment('stock', $detalle->cantidad);
                $detalle->tarjeta?->increment('stock', $detalle->cantidad);
            }

            $pedido->update(['estado' => 'cancelado']);
        });

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', __('messages.pedido_cancelled'));
    }

    // ── Helpers ─────────────────────────────────────────

    private function autorizar(Pedido $pedido): void
    {
        abort_unless((int) $pedido->usuario_id === (int) Auth::id(), 403);
    }

    private function verificarStock($producto, int $cantidad, ?string $nombre): void
    {
        if (! $producto) {
            throw ValidationException::withMessages([
                'productos' => __('messages.producto_no_existe'),
            ]);
        }

        if ($producto->stock < $cantidad) {
            throw ValidationException::withMessages([
                'productos' => __('messages.stock_insuficiente', ['producto' => $nombre, 'stock' => $producto->stock]),
            ]);
        }
    }
}
