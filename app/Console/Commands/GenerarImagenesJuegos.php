<?php

namespace App\Console\Commands;

use App\Models\VideoJuego;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerarImagenesJuegos extends Command
{
    protected $signature = 'juegos:generar-imagenes {--force : Regenerar imagenes existentes}';
    protected $description = 'Genera imagenes para videojuegos usando OpenAI GPT Image 1';

    public function handle(): int
    {
        $apiKey = config('services.openai.key');

        if (! $apiKey) {
            $this->error('Falta OPENAI_API_KEY en el archivo .env');
            return self::FAILURE;
        }

        $juegos = VideoJuego::all();

        if ($juegos->isEmpty()) {
            $this->warn('No hay videojuegos en la base de datos. Ejecuta primero: php artisan db:seed');
            return self::SUCCESS;
        }

        $this->info("Generando imagenes para {$juegos->count()} videojuegos...");
        $bar = $this->output->createProgressBar($juegos->count());
        $bar->start();

        $generadas = 0;
        $omitidas = 0;
        $errores = 0;

        foreach ($juegos as $juego) {
            if ($juego->imagen && ! $this->option('force')) {
                $omitidas++;
                $bar->advance();
                continue;
            }

            $prompt = "Video game cover art for a game called \"{$juego->titulo}\". "
                . "Genre: {$juego->categoria->nombre}. "
                . "Professional game cover design, vibrant colors, high quality digital art, "
                . "no text or letters on the image.";

            try {
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$apiKey}",
                ])->timeout(60)->post('https://api.openai.com/v1/images/generations', [
                    'model' => 'gpt-image-1',
                    'prompt' => $prompt,
                    'n' => 1,
                    'size' => '1024x1024',
                ]);

                if ($response->failed()) {
                    $error = $response->json('error.message', 'Error desconocido');
                    $this->newLine();
                    $this->error("Error en \"{$juego->titulo}\": {$error}");
                    $errores++;
                    $bar->advance();
                    continue;
                }

                $imageData = $response->json('data.0.b64_json');

                if (! $imageData) {
                    $url = $response->json('data.0.url');
                    if ($url) {
                        $imageData = base64_encode(Http::timeout(30)->get($url)->body());
                    }
                }

                if (! $imageData) {
                    $this->newLine();
                    $this->error("No se pudo obtener imagen para \"{$juego->titulo}\"");
                    $errores++;
                    $bar->advance();
                    continue;
                }

                $filename = 'videojuegos/' . Str::slug($juego->titulo) . '.png';
                Storage::disk('public')->put($filename, base64_decode($imageData));

                $juego->update(['imagen' => $filename]);
                $generadas++;
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Excepcion en \"{$juego->titulo}\": {$e->getMessage()}");
                $errores++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Generadas: {$generadas} | Omitidas: {$omitidas} | Errores: {$errores}");

        return $errores > 0 ? self::FAILURE : self::SUCCESS;
    }
}
