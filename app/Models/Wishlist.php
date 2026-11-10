<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'videojuego_id',
        'fecha_agregado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_agregado' => 'datetime',
        ];
    }

    // ── Relaciones ──────────────────────────────────────

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function videojuego(): BelongsTo
    {
        return $this->belongsTo(VideoJuego::class, 'videojuego_id');
    }

    // ── Scopes ──────────────────────────────────────────

    public function scopeDelUsuario(Builder $query, int $usuarioId): Builder
    {
        return $query->where('usuario_id', $usuarioId);
    }

    public function scopeDelVideojuego(Builder $query, int $videojuegoId): Builder
    {
        return $query->where('videojuego_id', $videojuegoId);
    }
}
