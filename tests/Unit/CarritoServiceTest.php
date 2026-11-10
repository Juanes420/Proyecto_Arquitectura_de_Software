<?php

namespace Tests\Unit;

use App\Models\Dlc;
use App\Models\Tarjeta;
use App\Models\VideoJuego;
use App\Services\CarritoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CarritoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_agregar_suma_cantidades_sin_pasar_el_stock(): void
    {
        $juego = VideoJuego::factory()->create(['precio' => 20, 'stock' => 3]);
        $carrito = app(CarritoService::class);

        $carrito->agregar('videojuego', $juego->id, 2);
        $carrito->agregar('videojuego', $juego->id, 2);

        $this->assertSame([$juego->id => 3], $carrito->porTipo()['videojuego']);
        $this->assertSame(3, $carrito->cantidad());
        $this->assertEquals(60, $carrito->total());
    }

    public function test_los_dlc_no_dependen_de_stock_y_se_limitan_a_diez(): void
    {
        $dlc = Dlc::factory()->create(['precio' => 5]);
        $carrito = app(CarritoService::class);

        $carrito->agregar('dlc', $dlc->id, 15);

        $this->assertSame([$dlc->id => CarritoService::MAXIMO_POR_PRODUCTO], $carrito->porTipo()['dlc']);
    }

    public function test_actualizar_a_cero_quita_el_producto(): void
    {
        $tarjeta = Tarjeta::factory()->create(['stock' => 10]);
        $carrito = app(CarritoService::class);

        $carrito->agregar('tarjeta', $tarjeta->id);
        $carrito->actualizar('tarjeta', $tarjeta->id, 0);

        $this->assertTrue($carrito->items()->isEmpty());
        $this->assertSame(0, $carrito->cantidad());
    }

    public function test_no_se_puede_agregar_un_producto_agotado(): void
    {
        $juego = VideoJuego::factory()->create(['stock' => 0]);

        $this->expectException(ValidationException::class);

        app(CarritoService::class)->agregar('videojuego', $juego->id);
    }

    public function test_los_productos_eliminados_desaparecen_del_carrito(): void
    {
        $juego = VideoJuego::factory()->create(['stock' => 5]);
        $carrito = app(CarritoService::class);

        $carrito->agregar('videojuego', $juego->id);
        $juego->delete();

        $this->assertTrue($carrito->items()->isEmpty());
        $this->assertSame(0, $carrito->cantidad());
    }

    public function test_si_baja_el_stock_se_cobra_la_cantidad_que_se_muestra(): void
    {
        $juego = VideoJuego::factory()->create(['precio' => 10, 'stock' => 5]);
        $carrito = app(CarritoService::class);

        $carrito->agregar('videojuego', $juego->id, 5);
        $juego->update(['stock' => 2]);

        $this->assertSame(2, $carrito->items()->first()['cantidad']);
        $this->assertSame([$juego->id => 2], $carrito->porTipo()['videojuego']);
        $this->assertEquals(20, $carrito->total());
    }
}
