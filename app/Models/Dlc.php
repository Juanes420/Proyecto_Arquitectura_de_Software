<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dlc extends Model
{
    use HasFactory;

    protected $table = 'dlcs';

    protected $fillable = [
        'videojuego_id',
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'fecha_lanzamiento',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'fecha_lanzamiento' => 'date',
        ];
    }

    // Imagen horizontal de Steam o URL propia; los DLC sin imagen usan la del juego.
    protected function imagenUrl(): Attribute
    {
        return Attribute::get(fn () => $this->imagen ?: $this->videojuego?->imagen_url);
    }

    // ── Relaciones ──────────────────────────────────────

    public function videojuego(): BelongsTo
    {
        return $this->belongsTo(VideoJuego::class, 'videojuego_id');
    }

    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'dlc_id');
    }
}
