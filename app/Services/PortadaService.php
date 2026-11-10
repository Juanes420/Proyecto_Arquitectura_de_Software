<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\VideoJuego;
use Illuminate\Support\Str;

class PortadaService
{
    // Cada diapositiva del carrusel de inicio muestra un juego distinto con un motivo distinto para verlo.
    public function diapositivas(): array
    {
        $usados = [];
        $diapositivas = [];

        $marca = $this->juego(fn ($consulta) => $consulta->orderByDesc('precio'), $usados);
        if ($marca) {
            $diapositivas[] = [
                'etiqueta' => 'GameVault',
                'titulo' => __('messages.hero_title'),
                'texto' => __('messages.hero_text'),
                'juego' => $marca,
                'enlace' => route('videojuegos.index'),
                'accion' => __('messages.explore_catalog'),
            ];
        }

        $nuevo = $this->juego(fn ($consulta) => $consulta->latest(), $usados);
        if ($nuevo) {
            $diapositivas[] = [
                'etiqueta' => __('messages.slide_new'),
                'titulo' => $nuevo->titulo,
                'texto' => Str::limit($nuevo->descripcion, 150),
                'juego' => $nuevo,
                'enlace' => route('videojuegos.show', $nuevo),
                'accion' => __('messages.view_game'),
            ];
        }

        $barato = $this->juego(fn ($consulta) => $consulta->orderBy('precio'), $usados);
        if ($barato) {
            $diapositivas[] = [
                'etiqueta' => __('messages.slide_best_price'),
                'titulo' => $barato->titulo,
                'texto' => __('messages.slide_price_text', ['precio' => '$' . number_format($barato->precio, 2)]),
                'juego' => $barato,
                'enlace' => route('videojuegos.show', $barato),
                'accion' => __('messages.view_game'),
            ];
        }

        $categoria = Categoria::withCount('videojuegos')->orderByDesc('videojuegos_count')->first();
        $deCategoria = $categoria
            ? $this->juego(fn ($consulta) => $consulta->where('categoria_id', $categoria->id)->latest(), $usados)
            : null;
        if ($deCategoria) {
            $diapositivas[] = [
                'etiqueta' => __('messages.slide_category'),
                'titulo' => $categoria->nombre,
                'texto' => $categoria->descripcion ?: __('messages.slide_category_text', ['total' => $categoria->videojuegos_count]),
                'juego' => $deCategoria,
                'enlace' => route('videojuegos.index', ['categoria' => $categoria->id]),
                'accion' => __('messages.view_category'),
            ];
        }

        return $diapositivas;
    }

    private function juego(callable $orden, array &$usados): ?VideoJuego
    {
        $consulta = VideoJuego::enStock()->whereNotNull('imagen')->whereNotIn('id', $usados);
        $juego = $orden($consulta)->first();

        if ($juego) {
            $usados[] = $juego->id;
        }

        return $juego;
    }
}
