<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TarjetaRequest;
use App\Models\Tarjeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TarjetaController extends Controller
{
    public function index(): View
    {
        $tarjetas = Tarjeta::orderBy('nombre')->paginate(15);

        return view('admin.tarjetas.index', compact('tarjetas'));
    }

    public function create(): View
    {
        return view('admin.tarjetas.create');
    }

    public function store(TarjetaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Tarjeta::create($validated);

        return redirect()->route('admin.tarjetas.index')
            ->with('success', __('messages.tarjeta_created'));
    }

    public function show(Tarjeta $tarjeta): View
    {
        return view('admin.tarjetas.show', compact('tarjeta'));
    }

    public function edit(Tarjeta $tarjeta): View
    {
        return view('admin.tarjetas.edit', compact('tarjeta'));
    }

    public function update(TarjetaRequest $request, Tarjeta $tarjeta): RedirectResponse
    {
        $validated = $request->validated();

        $tarjeta->update($validated);

        return redirect()->route('admin.tarjetas.index')
            ->with('success', __('messages.tarjeta_updated'));
    }

    public function destroy(Tarjeta $tarjeta): RedirectResponse
    {
        if ($tarjeta->detallePedidos()->exists()) {
            return redirect()->route('admin.tarjetas.index')
                ->with('error', __('messages.tarjeta_has_pedidos'));
        }

        $tarjeta->delete();

        return redirect()->route('admin.tarjetas.index')
            ->with('success', __('messages.tarjeta_deleted'));
    }
}