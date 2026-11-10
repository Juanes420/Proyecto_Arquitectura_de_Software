<?php

namespace App\Http\Controllers;

use App\Models\VideoJuego;
use App\Services\PortadaService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(PortadaService $portada): View
    {
        $diapositivas = $portada->diapositivas();
        $destacados = VideoJuego::with('categoria')->enStock()->latest()->take(5)->get();
        $totalJuegos = VideoJuego::count();

        return view('welcome', compact('diapositivas', 'destacados', 'totalJuegos'));
    }
}
