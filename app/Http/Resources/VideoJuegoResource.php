<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoJuegoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'plataforma' => $this->plataforma,
            'categoria' => $this->categoria?->nombre,
            'precio' => (float) $this->precio,
            'stock' => $this->stock,
            'imagen' => $this->imagen ? asset('storage/'.$this->imagen) : null,
            'enlace' => route('videojuegos.show', $this->resource),
        ];
    }
}
