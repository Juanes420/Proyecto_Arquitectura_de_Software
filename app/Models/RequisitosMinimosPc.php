<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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
        'sistema_operativo_recomendado',
        'procesador_recomendado',
        'memoria_ram_recomendado',
        'tarjeta_grafica_recomendado',
        'almacenamiento_recomendado',
        'directx_recomendado',
    ];

    public const COMPONENTES = ['sistema_operativo', 'procesador', 'memoria_ram', 'tarjeta_grafica', 'almacenamiento', 'directx'];

    // Filas para la tabla de la ficha: [componente => ['minimo' => ..., 'recomendado' => ...]], sin las vacias.
    public function componentes(): array
    {
        $filas = [];

        foreach (self::COMPONENTES as $componente) {
            $minimo = $this->{$componente};
            $recomendado = $this->{$componente . '_recomendado'};

            if ($minimo || $recomendado) {
                $filas[$componente] = ['minimo' => $minimo, 'recomendado' => $recomendado];
            }
        }

        return $filas;
    }

    public function tieneRecomendados(): bool
    {
        return collect(self::COMPONENTES)->contains(fn ($componente) => filled($this->{$componente . '_recomendado'}));
    }

    // Datos que el panel "Tu equipo" compara en el navegador.
    public function datosComparacion(): array
    {
        return [
            'ram_minima' => self::gigas($this->memoria_ram),
            'ram_recomendada' => self::gigas($this->memoria_ram_recomendado),
            'requiere_windows' => Str::contains(Str::lower($this->sistema_operativo . ' ' . $this->sistema_operativo_recomendado), 'windows'),
        ];
    }

    // "12 GB de RAM" => 12; "512 MB" => 0.5; sin numero => null.
    public static function gigas(?string $texto): ?float
    {
        if (! preg_match('/(\d+(?:[.,]\d+)?)\s*(GB|MB)/i', (string) $texto, $coincidencia)) {
            return null;
        }

        $valor = (float) str_replace(',', '.', $coincidencia[1]);

        return Str::upper($coincidencia[2]) === 'MB' ? round($valor / 1024, 2) : $valor;
    }

    // ── Relaciones ──────────────────────────────────────

    public function videojuego(): BelongsTo
    {
        return $this->belongsTo(VideoJuego::class, 'videojuego_id');
    }
}
