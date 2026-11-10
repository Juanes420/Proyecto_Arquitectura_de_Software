<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VideoJuego;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompraDesdeCarritoTest extends TestCase
{
    use RefreshDatabase;

    public function test_invitado_agrega_al_carrito_y_debe_iniciar_sesion_para_pagar(): void
    {
        $juego = VideoJuego::factory()->create(['stock' => 4]);

        $this->post(route('carrito.agregar'), ['tipo' => 'videojuego', 'id' => $juego->id])
            ->assertSessionHas('carrito.videojuego.' . $juego->id, 1);

        $this->get(route('pedidos.create'))->assertRedirect(route('login'));
    }

    public function test_comprar_ahora_y_confirmar_crea_el_pedido_y_vacia_el_carrito(): void
    {
        $usuario = User::factory()->create();
        $juego = VideoJuego::factory()->create(['precio' => 30, 'stock' => 4]);

        $this->actingAs($usuario)
            ->post(route('carrito.comprar'), ['tipo' => 'videojuego', 'id' => $juego->id])
            ->assertRedirect(route('pedidos.create'));

        $this->get(route('pedidos.create'))->assertOk()->assertSee($juego->titulo);

        $this->post(route('pedidos.store'))->assertRedirect();

        $this->assertSame(3, $juego->fresh()->stock);
        $this->assertDatabaseHas('pedidos', ['usuario_id' => $usuario->id, 'total' => 30]);
        $this->assertNull(session('carrito'));
    }
}
