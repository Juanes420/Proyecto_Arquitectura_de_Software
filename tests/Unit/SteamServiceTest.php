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

    public function test_convierte_los_requisitos_html_de_steam_en_columnas(): void
    {
        $html = '<strong>Mínimo:</strong><br><ul class="bb_ul"><li><strong>SO *:</strong> Windows 10<br></li>'
            . '<li><strong>Procesador:</strong> Intel Core i5-8400<br></li><li><strong>Memoria:</strong> 12 GB de RAM<br></li>'
            . '<li><strong>Gráficos:</strong> NVIDIA GTX 1060 &amp; AMD RX 580<br></li><li><strong>Almacenamiento:</strong> 60 GB de espacio disponible</li>'
            . '<li><strong>Tarjeta de sonido:</strong> Compatible</li></ul>';

        $this->assertSame([
            'sistema_operativo' => 'Windows 10',
            'procesador' => 'Intel Core i5-8400',
            'memoria_ram' => '12 GB de RAM',
            'tarjeta_grafica' => 'NVIDIA GTX 1060 & AMD RX 580',
            'almacenamiento' => '60 GB de espacio disponible',
        ], (new SteamService)->requisitos($html));
    }
}
