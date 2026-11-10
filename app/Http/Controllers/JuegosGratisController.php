<?php

namespace App\Http\Controllers;

use App\Services\FreeToGameService;
use Illuminate\View\View;

class JuegosGratisController extends Controller
{
    public function index(FreeToGameService $freeToGame): View
    {
        return view('juegos-gratis.index', ['juegos' => $freeToGame->populares()]);
    }
}
