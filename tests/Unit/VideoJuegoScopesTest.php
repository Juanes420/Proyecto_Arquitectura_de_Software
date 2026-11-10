<?php

namespace Tests\Unit;

use App\Models\RequisitosMinimosPc;
use App\Models\VideoJuego;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoJuegoScopesTest extends TestCase
{
    use RefreshDatabase;

    public function test_filtrar_combina_busqueda_plataforma_y_rango_de_precio(): void
    {
        $buscado = VideoJuego::factory()->create(['titulo' => 'Hollow Knight', 'plataforma' => 'PC', 'precio' => 15]);
        VideoJuego::factory()->create(['titulo' => 'Hollow Knight Silksong', 'plataforma' => 'Nintendo Switch', 'precio' => 20]);
        VideoJuego::factory()->create(['titulo' => 'Hades', 'plataforma' => 'PC', 'precio' => 25]);

        $resultado = VideoJuego::filtrar(['buscar' => 'hollow', 'plataforma' => 'PC', 'precio_max' => 18])->pluck('id');

        $this->assertEquals([$buscado->id], $resultado->all());
    }

    public function test_sin_requisitos_excluye_los_que_ya_tienen_ficha_salvo_el_que_se_edita(): void
    {
        $libre = VideoJuego::factory()->create();
        $conFicha = VideoJuego::factory()->create();
        RequisitosMinimosPc::create([
            'videojuego_id' => $conFicha->id,
            'sistema_operativo' => 'Windows 10',
            'procesador' => 'i5',
            'memoria_ram' => '8 GB',
            'tarjeta_grafica' => 'GTX 1060',
            'almacenamiento' => '50 GB',
        ]);

        $this->assertEquals([$libre->id], VideoJuego::sinRequisitos()->pluck('id')->all());
        $this->assertEqualsCanonicalizing([$libre->id, $conFicha->id], VideoJuego::sinRequisitos($conFicha->id)->pluck('id')->all());
    }
}
