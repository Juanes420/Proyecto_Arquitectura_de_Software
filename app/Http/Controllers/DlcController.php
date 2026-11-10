<?php

namespace App\Http\Controllers;

use App\Models\Dlc;
use Illuminate\View\View;

class DlcController extends Controller
{
    public function index(): View
    {
        $dlcs = Dlc::with('videojuego')->latest('id')->paginate(16);

        return view('dlcs.index', compact('dlcs'));
    }
}
