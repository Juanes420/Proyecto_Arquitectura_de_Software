<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'pedido_id',
        'videojuego_id',
        'tarjeta_id',
        'cantidad',
        'precio_unit',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'precio_unit' => 'decimal:2',
        ];
    }

    // ── Relaciones ──────────────────────────────────────

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function videojuego(): BelongsTo
    {
        return $this->belongsTo(VideoJuego::class, 'videojuego_id');
    }

    public function tarjeta(): BelongsTo
    {
        return $this->belongsTo(Tarjeta::class, 'tarjeta_id');
    }
}
