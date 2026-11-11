<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VideoJuego;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResenaConEstrellasTest extends TestCase
{
    use RefreshDatabase;

    public function test_acepta_medias_estrellas_y_las_promedia(): void
    {
        $juego = VideoJuego::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('resenas.store', $juego), ['calificacion' => '4.5'])
            ->assertSessionHasNoErrors();
        $this->actingAs(User::factory()->create())
            ->post(route('resenas.store', $juego), ['calificacion' => '3.5']);

        $this->assertSame(4.5, $juego->resenas()->first()->calificacion);
        $this->assertSame(4.0, $juego->fresh()->promedio_calificacion);
    }

    public function test_rechaza_valores_que_no_son_medias_estrellas(): void
    {
        $juego = VideoJuego::factory()->create();

        foreach (['4.3', '0', '5.5'] as $valor) {
            $this->actingAs(User::factory()->create())
                ->post(route('resenas.store', $juego), ['calificacion' => $valor])
                ->assertSessionHasErrors('calificacion');
        }

        $this->assertSame(0, $juego->resenas()->count());
    }
}
