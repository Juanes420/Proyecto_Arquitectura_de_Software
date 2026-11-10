<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

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

    // La imagen puede ser una URL externa (Steam) o un archivo subido al disco publico.
    protected function imagenUrl(): Attribute
    {
        return Attribute::get(fn () => match (true) {
            ! $this->imagen => null,
            Str::startsWith($this->imagen, ['http://', 'https://']) => $this->imagen,
            default => asset('storage/' . $this->imagen),
        });
    }

    // Arte horizontal para fondos amplios; en Steam es la ilustracion sin logo pensada para recortarse.
    protected function fondoUrl(): Attribute
    {
        return Attribute::get(fn () => Str::endsWith((string) $this->imagen, 'library_600x900.jpg')
            ? Str::replaceLast('library_600x900.jpg', 'library_hero.jpg', $this->imagen)
            : $this->imagen_url);
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

    // ── Scopes ──────────────────────────────────────────

    public function scopeEnStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    // ── Accessors ───────────────────────────────────────

    public function getPromedioCalificacionAttribute(): ?float
    {
        $promedio = $this->resenas()->avg('calificacion');
        return $promedio ? round($promedio, 1) : null;
    }
}
