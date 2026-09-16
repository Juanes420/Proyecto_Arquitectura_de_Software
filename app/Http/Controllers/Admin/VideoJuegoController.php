<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\VideoJuego;
use Illuminate\Http\Request;

class VideoJuegoController extends Controller
{
    public function index()
    {
        $videojuegos = VideoJuego::with('categoria')
            ->orderBy('titulo')
            ->paginate(15);

        return view('admin.videojuegos.index', compact('videojuegos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.videojuegos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'plataforma' => ['required', 'string', 'max:100'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'descripcion' => ['nullable', 'string'],
            'imagen' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('videojuegos', 'public');
        }

        VideoJuego::create($validated);

        return redirect()->route('admin.videojuegos.index')
            ->with('success', __('messages.videojuego_created'));
    }

    public function show(VideoJuego $videojuego)
    {
        $videojuego->load(['categoria', 'dlcs', 'resenas.usuario', 'requisitosMinimosPC']);

        return view('admin.videojuegos.show', compact('videojuego'));
    }

    public function edit(VideoJuego $videojuego)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.videojuegos.edit', compact('videojuego', 'categorias'));
    }

    public function update(Request $request, VideoJuego $videojuego)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'plataforma' => ['required', 'string', 'max:100'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'descripcion' => ['nullable', 'string'],
            'imagen' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('videojuegos', 'public');
        }

        $videojuego->update($validated);

        return redirect()->route('admin.videojuegos.index')
            ->with('success', __('messages.videojuego_updated'));
    }

    public function destroy(VideoJuego $videojuego)
    {
        $videojuego->delete();

        return redirect()->route('admin.videojuegos.index')
            ->with('success', __('messages.videojuego_deleted'));
    }
}
