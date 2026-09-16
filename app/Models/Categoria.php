<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // ── Relaciones ──────────────────────────────────────

    public function videojuegos(): HasMany
    {
        return $this->hasMany(VideoJuego::class, 'categoria_id');
    }
}
