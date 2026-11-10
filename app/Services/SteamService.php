<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
            'requisitos' => [
                'minimo' => $this->requisitos($datos['pc_requirements']['minimum'] ?? ''),
                'recomendado' => $this->requisitos($datos['pc_requirements']['recommended'] ?? ''),
            ],
        ];
    }

    // Etiquetas de Steam en espanol => columna de requisitos_minimos_pc.
    private const ETIQUETAS_REQUISITOS = [
        'so' => 'sistema_operativo',
        'procesador' => 'procesador',
        'memoria' => 'memoria_ram',
        'gráficos' => 'tarjeta_grafica',
        'almacenamiento' => 'almacenamiento',
        'disco duro' => 'almacenamiento',
        'directx' => 'directx',
    ];

    // Convierte la lista HTML de pc_requirements ("<li><strong>SO:</strong> Windows 10</li>") en columnas.
    public function requisitos(string $html): array
    {
        preg_match_all('#<li>\s*<strong>\s*([^<]+?)\s*:?\s*</strong>(.*?)</li>#is', $html, $filas, PREG_SET_ORDER);

        $requisitos = [];

        foreach ($filas as [, $etiqueta, $valor]) {
            $clave = mb_strtolower(trim(preg_replace('/[^\p{L}\s]/u', '', html_entity_decode($etiqueta))));
            $columna = self::ETIQUETAS_REQUISITOS[$clave] ?? null;
            $valor = trim(html_entity_decode(strip_tags($valor)));

            if ($columna && $valor !== '' && ! isset($requisitos[$columna])) {
                $requisitos[$columna] = Str::limit($valor, 250, '');
            }
        }

        return $requisitos;
    }
}
