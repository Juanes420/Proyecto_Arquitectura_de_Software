<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\User;
use App\Models\VideoJuego;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalVideojuegos' => VideoJuego::count(),
            'totalClientes' => User::where('role', 'cliente')->count(),
            'totalPedidos' => Pedido::count(),
        ]);
    }
}
