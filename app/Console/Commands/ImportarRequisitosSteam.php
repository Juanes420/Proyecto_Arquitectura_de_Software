<?php

namespace App\Console\Commands;

use App\Models\RequisitosMinimosPc;
use App\Models\VideoJuego;
use App\Services\SteamService;
use Illuminate\Console\Command;
use Throwable;

class ImportarRequisitosSteam extends Command
{
    protected $signature = 'requisitos:importar-steam';

    protected $description = 'Crea la ficha de requisitos minimos y recomendados de los juegos de Steam que todavia no tienen';

    private const OBLIGATORIOS = ['sistema_operativo', 'procesador', 'memoria_ram', 'tarjeta_grafica'];

    public function handle(SteamService $steam): int
    {
        $importados = 0;

        // Solo juegos de Steam sin ficha: las fichas creadas por el admin no se tocan.
        $juegos = VideoJuego::where('imagen', 'like', '%/steam/apps/%')->doesntHave('requisitosMinimosPC')->get();

        foreach ($juegos as $juego) {
            try {
                $importados += $this->importar($steam, $juego) ? 1 : 0;
            } catch (Throwable $error) {
                $this->warn("No se pudieron importar los requisitos de {$juego->titulo}: {$error->getMessage()}");
            }
        }

        $this->info("Fichas de requisitos importadas de Steam: {$importados}");

        return self::SUCCESS;
    }

    private function importar(SteamService $steam, VideoJuego $juego): bool
    {
        $appId = $steam->appIdDesdeImagen($juego->imagen);
        $requisitos = $appId ? ($steam->detalles($appId)['requisitos'] ?? null) : null;
        $minimo = $requisitos['minimo'] ?? [];

        // La tabla exige los minimos principales; si Steam no los trae completos, el juego se queda sin ficha.
        foreach (self::OBLIGATORIOS as $columna) {
            if (empty($minimo[$columna])) {
                return false;
            }
        }

        $recomendado = collect($requisitos['recomendado'] ?? [])
            ->mapWithKeys(fn ($valor, $columna) => [$columna . '_recomendado' => $valor])
            ->all();

        // La columna de almacenamiento es obligatoria; algunos juegos de Steam no la publican.
        $minimo += ['almacenamiento' => '-'];

        // La relacion es 1:1: si el admin creo la ficha mientras tanto, se respeta la suya.
        if (RequisitosMinimosPc::where('videojuego_id', $juego->id)->exists()) {
            return false;
        }

        RequisitosMinimosPc::create(['videojuego_id' => $juego->id] + $minimo + $recomendado);

        return true;
    }
}
