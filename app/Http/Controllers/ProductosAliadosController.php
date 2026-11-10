<?php

namespace App\Http\Controllers;

use App\Contracts\ProductosAliadosService;
use Illuminate\View\View;

class ProductosAliadosController extends Controller
{
    public function index(ProductosAliadosService $aliados): View
    {
        return view('productos-aliados.index', [
            'productos' => $aliados->obtener(),
            'origen' => $aliados->origen(),
            'aliado' => config('services.aliados.nombre'),
        ]);
    }
}
