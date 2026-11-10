<?php

/**
 * Autor: Juan David Bedoya
 * Pedidos del cliente autenticado: confirmacion del carrito, historial y cancelacion.
 */

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\CarritoService;
use App\Services\PedidoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function __construct(
        private readonly PedidoService $pedidos,
        private readonly CarritoService $carrito,
    ) {}

    public function index(): View
    {
        $pedidos = Pedido::withCount('detalles')
            ->delUsuario(Auth::id())
            ->latest('fecha')
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create(): View|RedirectResponse
    {
        $items = $this->carrito->items();

        if ($items->isEmpty()) {
            return redirect()->route('carrito.index');
        }

        $total = $items->sum('subtotal');

        return view('pedidos.create', compact('items', 'total'));
    }

    public function store(): RedirectResponse
    {
        if ($this->carrito->tieneAgotados()) {
            return redirect()->route('carrito.index')->withErrors(['carrito' => __('messages.carrito_hay_agotados')]);
        }

        $productos = $this->carrito->porTipo();

        try {
            $pedido = $this->pedidos->crear(Auth::id(), $productos['videojuego'], $productos['tarjeta'], $productos['dlc']);
        } catch (ValidationException $error) {
            return redirect()->route('carrito.index')->withErrors($error->errors());
        }

        $this->carrito->vaciar();

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', __('messages.pedido_created'));
    }

    public function show(Pedido $pedido): View
    {
        $this->autorizar($pedido);

        $pedido->load('detalles.videojuego', 'detalles.tarjeta', 'detalles.dlc.videojuego');

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
