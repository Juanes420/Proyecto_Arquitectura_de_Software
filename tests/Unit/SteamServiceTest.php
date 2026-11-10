<?php

namespace Tests\Unit;

use App\Services\SteamService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SteamServiceTest extends TestCase
{
    public function test_convierte_la_respuesta_de_steam_en_datos_del_catalogo(): void
    {
        Http::fake([
            'store.steampowered.com/*' => Http::response([
                '620' => [
                    'success' => true,
                    'data' => [
                        'name' => 'Portal 2',
                        'short_description' => 'Puzles &amp; <b>portales</b>.',
                        'price_overview' => ['final' => 999],
                        'genres' => [['description' => 'Acción'], ['description' => 'Aventura']],
                    ],
                ],
            ]),
        ]);

        $datos = (new SteamService)->detalles(620);

        $this->assertSame('Portal 2', $datos['titulo']);
        $this->assertSame('Puzles & portales.', $datos['descripcion']);
        $this->assertSame(9.99, $datos['precio']);
        $this->assertSame(['Acción', 'Aventura'], $datos['generos']);
        $this->assertStringContainsString('/apps/620/library_600x900.jpg', $datos['imagen']);
    }

    public function test_devuelve_null_si_steam_no_tiene_el_juego(): void
    {
        Http::fake(['store.steampowered.com/*' => Http::response(['1' => ['success' => false]])]);

        $this->assertNull((new SteamService)->detalles(1));
    }
}
