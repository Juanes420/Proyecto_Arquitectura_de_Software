<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dlc extends Model
{
    use HasFactory;

    protected $table = 'dlcs';

    protected $fillable = [
        'videojuego_id',
        'nombre',
        'descripcion',
        'precio',
        'fecha_lanzamiento',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'fecha_lanzamiento' => 'date',
        ];
    }

    // ── Relaciones ──────────────────────────────────────

    public function videojuego(): BelongsTo
    {
        return $this->belongsTo(VideoJuego::class, 'videojuego_id');
    }
}
