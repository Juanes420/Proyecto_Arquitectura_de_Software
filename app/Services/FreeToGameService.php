<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class FreeToGameService
{
    private const CACHE_KEY = 'freetogame.populares';

    private const CACHE_SECONDS = 3600;

    public function populares(int $limite = 12): array
    {
        $juegos = Cache::get(self::CACHE_KEY);

        if ($juegos === null) {
            $juegos = $this->consultar();

            if ($juegos !== []) {
                Cache::put(self::CACHE_KEY, $juegos, self::CACHE_SECONDS);
            }
        }

        return array_slice($juegos, 0, $limite);
    }

    private function consultar(): array
    {
        try {
            $respuesta = Http::timeout(10)->get(config('services.freetogame.url').'/games', [
                'sort-by' => 'popularity',
            ]);
        } catch (Throwable) {
            return [];
        }

        if ($respuesta->failed()) {
            return [];
        }

        return array_map(fn (array $juego) => [
            'titulo' => $juego['title'],
            'imagen' => $juego['thumbnail'],
            'descripcion' => $juego['short_description'],
            'genero' => $juego['genre'],
            'plataforma' => $juego['platform'],
            'enlace' => $juego['game_url'],
        ], $respuesta->json());
    }
}
