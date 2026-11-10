<?php

namespace App\Http\Controllers;

use App\Models\Tarjeta;
use Illuminate\View\View;

class TarjetaRegaloController extends Controller
{
    public function index(): View
    {
        $tarjetas = Tarjeta::enStock()->orderBy('plataforma')->orderBy('precio')->get();

        return view('tarjetas-regalo.index', compact('tarjetas'));
    }
}
