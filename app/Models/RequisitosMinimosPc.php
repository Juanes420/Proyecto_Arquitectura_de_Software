<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitosMinimosPc extends Model
{
    use HasFactory;

    protected $table = 'requisitos_minimos_pc';

    protected $fillable = [
        'videojuego_id',
        'sistema_operativo',
        'procesador',
        'memoria_ram',
        'tarjeta_grafica',
        'almacenamiento',
        'directx',
    ];

    // ── Relaciones ──────────────────────────────────────

    public function videojuego(): BelongsTo
    {
        return $this->belongsTo(VideoJuego::class, 'videojuego_id');
    }
}
