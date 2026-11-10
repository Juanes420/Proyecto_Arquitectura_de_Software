<?php

namespace App\Console\Commands;

use App\Models\VideoJuego;
use App\Services\SteamService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportarDlcsSteam extends Command
{
    protected $signature = 'dlcs:importar-steam';

    protected $description = 'Reemplaza los DLC de prueba de los juegos importados de Steam por sus DLC reales';

    private const DLC_POR_JUEGO = 3;

    private const DLC_REVISADOS = 10;

    public function handle(SteamService $steam): int
    {
        $importados = 0;

        // Solo juegos de Steam que todavia no tienen DLC reales (los reales siempre traen imagen).
        $juegos = VideoJuego::where('imagen', 'like', '%/steam/apps/%')
            ->whereDoesntHave('dlcs', fn ($consulta) => $consulta->whereNotNull('imagen'))
            ->get();

        foreach ($juegos as $juego) {
            try {
                $importados += $this->importar($steam, $juego);
            } catch (Throwable $error) {
                $this->warn("No se pudieron importar los DLC de {$juego->titulo}: {$error->getMessage()}");
            }
        }

        $this->info("DLC importados de Steam: {$importados}");

        return self::SUCCESS;
    }

    private function importar(SteamService $steam, VideoJuego $juego): int
    {
        $appId = $steam->appIdDesdeImagen($juego->imagen);
        $datosJuego = $appId ? $steam->detalles($appId) : null;

        if (! $datosJuego) {
            return 0;
        }

        $nuevos = [];

        foreach (array_slice($datosJuego['dlc'], 0, self::DLC_REVISADOS) as $dlcId) {
            $datos = $steam->detalles($dlcId);

            if ($datos && $datos['precio'] !== null) {
                $nuevos[] = [
                    'nombre' => $datos['titulo'],
                    'descripcion' => $datos['descripcion'],
                    'precio' => $datos['precio'],
                    'imagen' => $datos['imagen_horizontal'],
                ];
            }

            if (count($nuevos) === self::DLC_POR_JUEGO) {
                break;
            }
        }

        // Si Steam no devolvio nada se conservan los DLC actuales; los que ya estan en pedidos nunca se borran.
        if ($nuevos === []) {
            return 0;
        }

        DB::transaction(function () use ($juego, $nuevos) {
            $juego->dlcs()->whereNull('imagen')->whereDoesntHave('detallePedidos')->delete();
            $juego->dlcs()->createMany($nuevos);
        });

        return count($nuevos);
    }
}
