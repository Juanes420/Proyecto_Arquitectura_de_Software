<?php

use App\Http\Controllers\Api\VideoJuegoApiController;
use Illuminate\Support\Facades\Route;

Route::get('/videojuegos', [VideoJuegoApiController::class, 'index'])->name('api.videojuegos.index');
