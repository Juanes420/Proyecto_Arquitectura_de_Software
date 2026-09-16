<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VideoJuego extends Model
{
    use HasFactory;

    protected $table = 'videojuegos';

    protected $fillable = [
        'titulo',
        'plataforma',
        'precio',
        'stock',
        'categoria_id',
        'descripcion',
        'imagen',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    // ── Relaciones ──────────────────────────────────────

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function dlcs(): HasMany
    {
        return $this->hasMany(Dlc::class, 'videojuego_id');
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class, 'videojuego_id');
    }

    public function requisitosMinimosPC(): HasOne
    {
        return $this->hasOne(RequisitosMinimosPc::class, 'videojuego_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'videojuego_id');
    }

    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'videojuego_id');
    }

    // ── Accessors ───────────────────────────────────────

    public function getPromedioCalificacionAttribute(): ?float
    {
        $promedio = $this->resenas()->avg('calificacion');
        return $promedio ? round($promedio, 1) : null;
    }
}
