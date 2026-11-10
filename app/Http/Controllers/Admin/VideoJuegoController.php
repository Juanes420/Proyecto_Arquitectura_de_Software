<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoJuegoRequest;
use App\Models\Categoria;
use App\Models\VideoJuego;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VideoJuegoController extends Controller
{
    public function index(): View
    {
        $videojuegos = VideoJuego::with('categoria')
            ->orderBy('titulo')
            ->paginate(15);

        return view('admin.videojuegos.index', compact('videojuegos'));
    }

    public function create(): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.videojuegos.create', compact('categorias'));
    }

    public function store(VideoJuegoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('videojuegos', 'public');
        }

        VideoJuego::create($validated);

        return redirect()->route('admin.videojuegos.index')
            ->with('success', __('messages.videojuego_created'));
    }

    public function show(VideoJuego $videojuego): View
    {
        $videojuego->load(['categoria', 'dlcs', 'resenas.usuario', 'requisitosMinimosPC']);

        return view('admin.videojuegos.show', compact('videojuego'));
    }

    public function edit(VideoJuego $videojuego): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.videojuegos.edit', compact('videojuego', 'categorias'));
    }

    public function update(VideoJuegoRequest $request, VideoJuego $videojuego): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('videojuegos', 'public');
        }

        $videojuego->update($validated);

        return redirect()->route('admin.videojuegos.index')
            ->with('success', __('messages.videojuego_updated'));
    }

    public function destroy(VideoJuego $videojuego): RedirectResponse
    {
        $videojuego->delete();

        return redirect()->route('admin.videojuegos.index')
            ->with('success', __('messages.videojuego_deleted'));
    }
}
