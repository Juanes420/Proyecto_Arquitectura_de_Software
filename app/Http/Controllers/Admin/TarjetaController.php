<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarjeta;
use Illuminate\Http\Request;

class TarjetaController extends Controller
{
    public function index()
    {
        $tarjetas = Tarjeta::orderBy('nombre')->paginate(15);

        return view('admin.tarjetas.index', compact('tarjetas'));
    }

    public function create()
    {
        return view('admin.tarjetas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'plataforma' => ['required', 'string', 'max:100'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'imagen' => ['nullable', 'string', 'max:500'],
        ]);

        Tarjeta::create($validated);

        return redirect()->route('admin.tarjetas.index')
            ->with('success', __('messages.tarjeta_created'));
    }

    public function show(Tarjeta $tarjeta)
    {
        return view('admin.tarjetas.show', compact('tarjeta'));
    }

    public function edit(Tarjeta $tarjeta)
    {
        return view('admin.tarjetas.edit', compact('tarjeta'));
    }

    public function update(Request $request, Tarjeta $tarjeta)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'plataforma' => ['required', 'string', 'max:100'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'imagen' => ['nullable', 'string', 'max:500'],
        ]);

        $tarjeta->update($validated);

        return redirect()->route('admin.tarjetas.index')
            ->with('success', __('messages.tarjeta_updated'));
    }

    public function destroy(Tarjeta $tarjeta)
    {
        $tarjeta->delete();

        return redirect()->route('admin.tarjetas.index')
            ->with('success', __('messages.tarjeta_deleted'));
    }
}