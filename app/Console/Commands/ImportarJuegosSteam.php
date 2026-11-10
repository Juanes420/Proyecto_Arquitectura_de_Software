<?php

namespace App\Console\Commands;

use App\Models\Categoria;
use App\Models\VideoJuego;
use App\Services\SteamService;
use Database\Factories\VideoJuegoFactory;
use Illuminate\Console\Command;

class ImportarJuegosSteam extends Command
{
    protected $signature = 'juegos:importar-steam';

    protected $description = 'Reemplaza los videojuegos de prueba por juegos reales de Steam (nombre, descripcion, precio y portada)';

    private const APP_IDS = [
        1245620, 1091500, 292030, 1174180, 1145360, 367520, 413150, 504230,
        1086940, 814380, 105600, 620, 632470, 582010, 1593500, 2050650,
        1551360, 1426210, 1244090, 1868140, 289070, 255710, 990080, 1627720,
    ];

    // Steam en espanol => categoria de GameVault, de la mas especifica a la mas general.
    private const GENEROS = [
        'Carreras' => 'Carreras',
        'Deportes' => 'Deportes',
        'Estrategia' => 'Estrategia',
        'Simuladores' => 'Simulación',
        'Rol' => 'RPG',
        'Aventura' => 'Aventura',
        'Acción' => 'Acción',
    ];

    public function handle(SteamService $steam): int
    {
        // Solo se reemplazan los juegos de prueba del factory; los creados por un admin se respetan.
        $pendientes = VideoJuego::whereIn('titulo', VideoJuegoFactory::TITULOS)->orderBy('id')->get();

        $titulosUsados = VideoJuego::pluck('titulo');
        $importados = 0;

        foreach (self::APP_IDS as $appId) {
            if ($pendientes->isEmpty()) {
                break;
            }

            $datos = $steam->detalles($appId);

            if (! $datos || $titulosUsados->contains($datos['titulo'])) {
                continue;
            }

            $juego = $pendientes->shift();
            $juego->update([
                'titulo' => $datos['titulo'],
                'descripcion' => $datos['descripcion'],
                'imagen' => $datos['imagen'],
                'plataforma' => 'PC',
                'precio' => $datos['precio'] ?? $juego->precio,
                'categoria_id' => $this->categoriaPara($datos['generos']) ?? $juego->categoria_id,
            ]);

            $titulosUsados->push($datos['titulo']);
            $importados++;
        }

        $this->info("Juegos importados de Steam: {$importados}");

        return self::SUCCESS;
    }

    private function categoriaPara(array $generos): ?int
    {
        foreach (self::GENEROS as $genero => $nombre) {
            $categoria = in_array($genero, $generos) ? Categoria::where('nombre', $nombre)->first() : null;

            if ($categoria) {
                return $categoria->id;
            }
        }

        return null;
    }
}
