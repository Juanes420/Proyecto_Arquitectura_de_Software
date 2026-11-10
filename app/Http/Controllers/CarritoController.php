<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarritoRequest;
use App\Services\CarritoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CarritoController extends Controller
{
    public function __construct(private readonly CarritoService $carrito)
    {
    }

    public function index(): View
    {
        $items = $this->carrito->items();
        $total = $items->sum('subtotal');

        return view('carrito.index', compact('items', 'total'));
    }

    public function agregar(CarritoRequest $request): RedirectResponse
    {
        $this->carrito->agregar($request->tipo(), $request->producto(), max($request->cantidad(), 1));

        return back()->with('success', __('messages.carrito_agregado'));
    }

    public function comprar(CarritoRequest $request): RedirectResponse
    {
        $this->carrito->agregar($request->tipo(), $request->producto(), max($request->cantidad(), 1));

        return redirect()->route('pedidos.create');
    }

    public function actualizar(CarritoRequest $request): RedirectResponse
    {
        $this->carrito->actualizar($request->tipo(), $request->producto(), $request->cantidad(0));

        return redirect()->route('carrito.index');
    }

    public function quitar(CarritoRequest $request): RedirectResponse
    {
        $this->carrito->quitar($request->tipo(), $request->producto());

        return redirect()->route('carrito.index')->with('success', __('messages.carrito_quitado'));
    }
}
