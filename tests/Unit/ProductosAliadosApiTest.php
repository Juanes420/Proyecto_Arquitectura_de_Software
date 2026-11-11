<?php

namespace Tests\Unit;

use App\Services\ProductosAliados\ProductosAliadosApi;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductosAliadosApiTest extends TestCase
{
    public function test_lee_la_lista_envuelta_en_productos_de_la_tienda_de_muebles(): void
    {
        Http::fake(['muebles.test/*' => Http::response([
            'total' => 1,
            'productos' => [[
                'id' => 5,
                'nombre' => 'Silla Escandinava',
                'descripcion' => 'Mueble de la categoría Sillas.',
                'precio' => '320000.00',
                'url' => 'http://muebles.test/productos/5',
            ]],
        ])]);

        $productos = (new ProductosAliadosApi('http://muebles.test/api/productos'))->obtener();

        $this->assertCount(1, $productos);
        $this->assertSame('Silla Escandinava', $productos[0]['nombre']);
        $this->assertSame('320000.00', $productos[0]['precio']);
        $this->assertSame('http://muebles.test/productos/5', $productos[0]['enlace']);
    }
}
