<?php

namespace Tests\Unit;

use App\Models\Dlc;
use App\Models\Pedido;
use App\Models\User;
use App\Models\VideoJuego;
use App\Services\PedidoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PedidoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_pedido_calcula_el_total_y_descuenta_el_stock(): void
    {
        $usuario = User::factory()->create();
        $juego = VideoJuego::factory()->create(['precio' => 50000, 'stock' => 10]);

        $pedido = app(PedidoService::class)->crear($usuario->id, [$juego->id => 3], []);

        $this->assertEquals(150000, $pedido->total);
        $this->assertSame('pendiente', $pedido->estado);
        $this->assertCount(1, $pedido->detalles);
        $this->assertSame(7, $juego->fresh()->stock);
    }

    public function test_crear_pedido_sin_stock_suficiente_lanza_error_y_no_guarda_nada(): void
    {
        $usuario = User::factory()->create();
        $juego = VideoJuego::factory()->create(['precio' => 50000, 'stock' => 2]);

        try {
            app(PedidoService::class)->crear($usuario->id, [$juego->id => 5], []);
            $this->fail('Se esperaba una ValidationException por stock insuficiente.');
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('productos', $e->errors());
        }

        $this->assertSame(0, Pedido::count());
        $this->assertSame(2, $juego->fresh()->stock);
    }

    public function test_pedido_con_dlc_no_controla_stock_y_cancelar_solo_devuelve_stock_fisico(): void
    {
        $usuario = User::factory()->create();
        $juego = VideoJuego::factory()->create(['precio' => 40, 'stock' => 5]);
        $dlc = Dlc::factory()->create(['videojuego_id' => $juego->id, 'precio' => 10]);
        $servicio = app(PedidoService::class);

        $pedido = $servicio->crear($usuario->id, [$juego->id => 2], [], [$dlc->id => 3]);

        $this->assertEquals(110, $pedido->total);
        $this->assertSame(1, $pedido->detalles()->whereNotNull('dlc_id')->count());
        $this->assertSame(3, $juego->fresh()->stock);

        $this->assertTrue($servicio->cancelar($pedido->fresh()));
        $this->assertSame(5, $juego->fresh()->stock);
        $this->assertSame('cancelado', $pedido->fresh()->estado);
    }
}
