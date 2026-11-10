<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoJuegoResource;
use App\Models\VideoJuego;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VideoJuegoApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $videojuegos = VideoJuego::with('categoria')->enStock()->orderBy('titulo')->get();

        return VideoJuegoResource::collection($videojuegos);
    }
}
