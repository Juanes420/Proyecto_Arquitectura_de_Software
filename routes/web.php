<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\VideoJuegoController as AdminVideoJuegoController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\VideoJuegoController;
use Illuminate\Support\Facades\Route;

// ── Página principal ────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Autenticación ───────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Catálogo público ────────────────────────────────────
Route::get('/videojuegos', [VideoJuegoController::class, 'index'])->name('videojuegos.index');
Route::get('/videojuegos/{videojuego}', [VideoJuegoController::class, 'show'])->name('videojuegos.show');

// ── Rutas autenticadas (cliente) ────────────────────────
Route::middleware('auth')->group(function () {
    // Reseñas
    Route::post('/videojuegos/{videojuego}/resenas', [ResenaController::class, 'store'])->name('resenas.store');
    Route::put('/resenas/{resena}', [ResenaController::class, 'update'])->name('resenas.update');
    Route::delete('/resenas/{resena}', [ResenaController::class, 'destroy'])->name('resenas.destroy');

    // TODO: Wishlist routes (Peña)
    // TODO: Pedidos routes (Bedoya)
});

// ── Panel Admin ─────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD Videojuegos (Admin)
    Route::resource('videojuegos', AdminVideoJuegoController::class);

    // TODO: CRUD Tarjetas (Bedoya)
    // TODO: CRUD Categorías (Peña)
});
