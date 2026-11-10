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

    // Imagen propia si el admin la puso; si no, la imagen oficial de la plataforma (Nintendo tiene una por monto).
    protected function imagenUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->imagen) {
                return $this->imagen;
            }

            $plataforma = Str::lower($this->plataforma . ' ' . $this->nombre);

            return match (true) {
                Str::contains($plataforma, 'steam') => self::IMAGEN_STEAM,
                Str::contains($plataforma, 'xbox') => asset('img/tarjetas/xbox.jpg'),
                Str::contains($plataforma, 'playstation') => asset('img/tarjetas/playstation.png'),
                Str::contains($plataforma, 'nintendo') && in_array((int) $this->precio, [100, 200], true) => asset('img/tarjetas/nintendo-' . (int) $this->precio . '.jpg'),
                default => null,
            };
        });
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
