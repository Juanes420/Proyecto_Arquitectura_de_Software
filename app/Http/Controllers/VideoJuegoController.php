<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\VideoJuego;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoJuegoController extends Controller
{
    public function index(Request $request): View
    {
        $videojuegos = VideoJuego::with('categoria')
            ->filtrar($request->only(['categoria', 'plataforma', 'precio_min', 'precio_max', 'buscar']))
            ->orderBy('titulo')
            ->paginate(12);
        $categorias = Categoria::orderBy('nombre')->get();
        $plataformas = VideoJuego::distinct()->pluck('plataforma');

        return view('videojuegos.index', compact('videojuegos', 'categorias', 'plataformas'));
    }

    public function show(Request $request, VideoJuego $videojuego): View
    {
        $videojuego->load(['categoria', 'dlcs', 'resenas.usuario', 'requisitosMinimosPC']);
        $miResena = $request->user() ? $videojuego->resenas->firstWhere('usuario_id', $request->user()->id) : null;

        return view('videojuegos.show', compact('videojuego', 'miResena'));
    }
}
