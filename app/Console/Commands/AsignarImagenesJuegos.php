<?php

namespace App\Console\Commands;

use App\Models\VideoJuego;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AsignarImagenesJuegos extends Command
{
    protected $signature = 'juegos:asignar-imagenes';
    protected $description = 'Asigna a cada videojuego sin imagen la portada ya generada que coincide con su titulo';

    public function handle(): int
    {
        $asignadas = 0;

        VideoJuego::whereNull('imagen')->orWhere('imagen', '')->each(function (VideoJuego $juego) use (&$asignadas) {
            $ruta = 'videojuegos/' . Str::slug($juego->titulo) . '.png';

            if (Storage::disk('public')->exists($ruta)) {
                $juego->update(['imagen' => $ruta]);
                $asignadas++;
            }
        });

        $this->info("Imagenes asignadas: {$asignadas}");

        return self::SUCCESS;
    }
}
