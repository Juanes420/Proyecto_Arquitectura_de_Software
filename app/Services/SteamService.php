<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SteamService
{
    private const URL_DETALLES = 'https://store.steampowered.com/api/appdetails';

    private const URL_PORTADA = 'https://shared.steamstatic.com/store_item_assets/steam/apps/%d/library_600x900.jpg';

    private const URL_CABECERA = 'https://shared.steamstatic.com/store_item_assets/steam/apps/%d/header.jpg';

    // El appid de Steam queda dentro de la URL de la portada importada.
    public function appIdDesdeImagen(?string $imagen): ?int
    {
        return preg_match('#/steam/apps/(\d+)/#', (string) $imagen, $coincidencia) ? (int) $coincidencia[1] : null;
    }

    public function detalles(int $appId): ?array
    {
        $respuesta = Http::timeout(15)->get(self::URL_DETALLES, [
            'appids' => $appId,
            'l' => 'spanish',
            'cc' => 'us',
        ]);

        $datos = $respuesta->json("{$appId}.data");

        if ($respuesta->failed() || ! $respuesta->json("{$appId}.success") || ! $datos) {
            return null;
        }

        $precio = $datos['price_overview']['final'] ?? null;

        return [
            'titulo' => trim(str_replace(['™', '®', ' — '], ['', '', ': '], $datos['name'])),
            'descripcion' => html_entity_decode(strip_tags($datos['short_description'] ?? '')),
            'imagen' => sprintf(self::URL_PORTADA, $appId),
            'precio' => $precio !== null ? $precio / 100 : null,
            'generos' => array_column($datos['genres'] ?? [], 'description'),
            'imagen_horizontal' => $datos['header_image'] ?? sprintf(self::URL_CABECERA, $appId),
            'dlc' => array_map('intval', $datos['dlc'] ?? []),
        ];
    }
}
