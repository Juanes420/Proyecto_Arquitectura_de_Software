<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Tarjeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'plataforma',
        'precio',
        'stock',
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

    private const IMAGEN_STEAM = 'https://store.fastly.steamstatic.com/public/images/gift/digital_cards_preview.png';

    // Steam publica la imagen de sus tarjetas; las de otras plataformas se dibujan en la vista si no tienen imagen.
    protected function imagenUrl(): Attribute
    {
        return Attribute::get(fn () => $this->imagen
            ?: (Str::contains(Str::lower($this->plataforma . ' ' . $this->nombre), 'steam') ? self::IMAGEN_STEAM : null));
    }

    // ── Relaciones ──────────────────────────────────────

    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'tarjeta_id');
    }

    // ── Scopes ──────────────────────────────────────────

    public function scopeEnStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }
}
