<?php

namespace App\Services\ProductosAliados;

use App\Contracts\ProductosAliadosService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class ProductosAliadosApi implements ProductosAliadosService
{
    private const CACHE_SECONDS = 600;

    private const CAMPOS = [
        'nombre' => ['nombre', 'name', 'titulo', 'title', 'producto'],
        'descripcion' => ['descripcion', 'description', 'detalle'],
        'precio' => ['precio', 'price', 'valor'],
        'imagen' => ['imagen', 'image', 'img', 'thumbnail', 'foto'],
        'enlace' => ['enlace', 'link', 'url'],
    ];

    public function __construct(private readonly string $url)
    {
    }

    public function obtener(): array
    {
        $cacheKey = 'aliados.'.md5($this->url);
        $productos = Cache::get($cacheKey);

        if ($productos === null) {
            $productos = $this->consultar();

            if ($productos !== []) {
                Cache::put($cacheKey, $productos, self::CACHE_SECONDS);
            }
        }

        return $productos;
    }

    public function origen(): string
    {
        return 'api';
    }

    private function consultar(): array
    {
        try {
            $respuesta = Http::timeout(15)->acceptJson()->get($this->url);
        } catch (Throwable) {
            return [];
        }

        if ($respuesta->failed() || ! is_array($respuesta->json())) {
            return [];
        }

        $items = $respuesta->json('data') ?? $respuesta->json();

        return array_values(array_filter(array_map(
            fn ($item) => is_array($item) ? $this->normalizar($item) : null,
            $items
        )));
    }

    private function normalizar(array $item): ?array
    {
        $producto = [];

        foreach (self::CAMPOS as $campo => $claves) {
            $producto[$campo] = collect($claves)->map(fn ($clave) => $item[$clave] ?? null)->first(fn ($valor) => is_scalar($valor));
        }

        return $producto['nombre'] === null ? null : $producto;
    }
}
