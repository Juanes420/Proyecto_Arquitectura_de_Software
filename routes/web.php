<?php

use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;
use App\Http\Controllers\Admin\RequisitosMinimosPcController as AdminRequisitosMinimosPcController;
use App\Http\Controllers\Admin\VideoJuegoController as AdminVideoJuegoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\VideoJuegoController;
use App\Http\Controllers\WishlistController;
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

    // Wishlist (Peña)
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{videojuego}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{videojuego}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

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

    // CRUD Categorías (Peña)
    Route::resource('categorias', AdminCategoriaController::class);

    // Requisitos mínimos PC (Peña) — no tiene vista show: se muestran
    // en el detalle público del videojuego.
    Route::resource('requisitos', AdminRequisitosMinimosPcController::class)
        ->parameters(['requisitos' => 'requisito'])
        ->except(['show']);
});
