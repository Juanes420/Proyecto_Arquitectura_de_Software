<?php

/**
 * Autor: Juanes Peña
 * CRUD de Categorías — sección administrador.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::withCount('videojuegos')
            ->orderBy('nombre')
            ->paginate(15);

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:categorias,nombre'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
        ]);

        Categoria::create($validated);

        return redirect()->route('admin.categorias.index')
            ->with('success', __('messages.categoria_created'));
    }

    public function show(Categoria $categoria): View
    {
        $categoria->load('videojuegos');

        return view('admin.categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria): View
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:categorias,nombre,' . $categoria->id],
            'descripcion' => ['nullable', 'string', 'max:1000'],
        ]);

        $categoria->update($validated);

        return redirect()->route('admin.categorias.index')
            ->with('success', __('messages.categoria_updated'));
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        // Una categoría con videojuegos asociados no se puede borrar:
        // la FK de videojuegos.categoria_id es obligatoria.
        if ($categoria->videojuegos()->exists()) {
            return redirect()->route('admin.categorias.index')
                ->with('error', __('messages.categoria_has_videojuegos'));
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', __('messages.categoria_deleted'));
    }
}
