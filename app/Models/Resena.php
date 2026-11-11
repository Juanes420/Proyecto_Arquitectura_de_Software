<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resena extends Model
{
    use HasFactory;

    protected $table = 'resenas';

    protected $fillable = [
        'usuario_id',
        'videojuego_id',
        'calificacion',
        'comentario',
    ];

    protected function casts(): array
    {
        return [
            'calificacion' => 'float',
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

    public function perteneceA(int $usuarioId): bool
    {
        return $this->usuario_id === $usuarioId;
    }

    // 4.5 => "4,5" en espanol y "4.5" en ingles; sin decimal si es entero.
    public static function formatear(?float $calificacion): string
    {
        $texto = rtrim(rtrim(number_format((float) $calificacion, 1, '.', ''), '0'), '.');

        return app()->getLocale() === 'es' ? str_replace('.', ',', $texto) : $texto;
    }
}
