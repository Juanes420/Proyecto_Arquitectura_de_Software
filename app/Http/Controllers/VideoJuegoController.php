<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\VideoJuego;
use Illuminate\Http\Request;

class VideoJuegoController extends Controller
{
    public function index(Request $request)
    {
        $query = VideoJuego::with('categoria');

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // Filtro por plataforma
        if ($request->filled('plataforma')) {
            $query->where('plataforma', $request->plataforma);
        }

        // Filtro por precio
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        // Búsqueda por título
        if ($request->filled('buscar')) {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }

        $videojuegos = $query->orderBy('titulo')->paginate(12);
        $categorias = Categoria::orderBy('nombre')->get();
        $plataformas = VideoJuego::distinct()->pluck('plataforma');

        return view('videojuegos.index', compact('videojuegos', 'categorias', 'plataformas'));
    }

    public function show(VideoJuego $videojuego)
    {
        $videojuego->load(['categoria', 'dlcs', 'resenas.usuario', 'requisitosMinimosPC']);

        return view('videojuegos.show', compact('videojuego'));
    }
}
