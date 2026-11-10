<?php

namespace Tests\Unit;

use App\Models\RequisitosMinimosPc;
use PHPUnit\Framework\TestCase;

class RequisitosMinimosPcTest extends TestCase
{
    public function test_extrae_los_gigas_de_la_ram(): void
    {
        $this->assertSame(12.0, RequisitosMinimosPc::gigas('12 GB de RAM'));
        $this->assertSame(0.5, RequisitosMinimosPc::gigas('512 MB RAM'));
        $this->assertNull(RequisitosMinimosPc::gigas('Depende del equipo'));
    }

    public function test_componentes_y_datos_de_comparacion(): void
    {
        $requisitos = new RequisitosMinimosPc([
            'sistema_operativo' => 'Windows 10',
            'memoria_ram' => '8 GB',
            'memoria_ram_recomendado' => '16 GB',
        ]);

        $this->assertSame(['minimo' => '8 GB', 'recomendado' => '16 GB'], $requisitos->componentes()['memoria_ram']);
        $this->assertArrayNotHasKey('directx', $requisitos->componentes());
        $this->assertTrue($requisitos->tieneRecomendados());
        $this->assertSame(['ram_minima' => 8.0, 'ram_recomendada' => 16.0, 'requiere_windows' => true], $requisitos->datosComparacion());
    }
}
