<?php

namespace App\Http\Controllers;

use App\Models\VideoJuego;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $destacados = VideoJuego::with('categoria')->enStock()->latest()->take(5)->get();
        $portada = $destacados->firstWhere('imagen');
        $totalJuegos = VideoJuego::count();

        return view('welcome', compact('destacados', 'portada', 'totalJuegos'));
    }
}
