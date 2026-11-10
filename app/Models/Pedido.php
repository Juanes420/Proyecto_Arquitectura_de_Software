<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'fecha',
        'estado',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'total' => 'decimal:2',
        ];
    }

    // ── Relaciones ──────────────────────────────────────

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }

    // ── Scopes y helpers ────────────────────────────────

    public function scopeDelUsuario(Builder $query, int $usuarioId): Builder
    {
        return $query->where('usuario_id', $usuarioId);
    }

    public function perteneceA(?int $usuarioId): bool
    {
        return (int) $this->usuario_id === (int) $usuarioId;
    }
}
