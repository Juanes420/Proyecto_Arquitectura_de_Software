<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // ── Relaciones ──────────────────────────────────────

    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'tarjeta_id');
    }
}
