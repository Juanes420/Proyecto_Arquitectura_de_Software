<?php

/**
 * Autor: Juan David Bedoya
 * Pedidos del cliente autenticado (con sus detalles de videojuegos y tarjetas).
 */

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Tarjeta;
use App\Models\VideoJuego;
use App\Services\PedidoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function __construct(private readonly PedidoService $pedidos)
    {
    }

    public function index(): View
    {
        $pedidos = Pedido::withCount('detalles')
            ->delUsuario(Auth::id())
            ->latest('fecha')
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create(Request $request): View
    {
        $videojuegos = VideoJuego::enStock()->orderBy('titulo')->get();
        $tarjetas = Tarjeta::enStock()->orderBy('nombre')->get();
        $preseleccionado = (int) $request->query('videojuego');

        return view('pedidos.create', compact('videojuegos', 'tarjetas', 'preseleccionado'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'videojuegos' => ['nullable', 'array'],
            'videojuegos.*' => ['nullable', 'integer', 'min:0', 'max:10'],
            'tarjetas' => ['nullable', 'array'],
            'tarjetas.*' => ['nullable', 'integer', 'min:0', 'max:10'],
        ]);

        $pedido = $this->pedidos->crear(Auth::id(), $validated['videojuegos'] ?? [], $validated['tarjetas'] ?? []);

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', __('messages.pedido_created'));
    }

    public function show(Pedido $pedido): View
    {
        $this->autorizar($pedido);

        $pedido->load('detalles.videojuego', 'detalles.tarjeta');

        return view('pedidos.show', compact('pedido'));
    }

    public function cancelar(Pedido $pedido): RedirectResponse
    {
        $this->autorizar($pedido);

        if (! $this->pedidos->cancelar($pedido)) {
            return back()->with('error', __('messages.pedido_no_cancelable'));
        }

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', __('messages.pedido_cancelled'));
    }

    private function autorizar(Pedido $pedido): void
    {
        abort_unless($pedido->perteneceA(Auth::id()), 403);
    }
}
