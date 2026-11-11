<?php

namespace App\Services\ProductosAliados;

use App\Contracts\ProductosAliadosService;

class ProductosAliadosLocal implements ProductosAliadosService
{
    public function obtener(): array
    {
        return [
            [
                'nombre' => 'Sofá Nórdico 3 puestos',
                'descripcion' => 'Mueble de la categoría Sofás, ideal para Sala.',
                'precio' => 1890000,
                'imagen' => null,
                'enlace' => null,
            ],
            [
                'nombre' => 'Mesa de Centro Roble',
                'descripcion' => 'Mueble de la categoría Mesas, ideal para Sala.',
                'precio' => 680000,
                'imagen' => null,
                'enlace' => null,
            ],
            [
                'nombre' => 'Silla Escandinava',
                'descripcion' => 'Mueble de la categoría Sillas, ideal para Sala.',
                'precio' => 320000,
                'imagen' => null,
                'enlace' => null,
            ],
        ];
    }

    public function origen(): string
    {
        return 'local';
    }
}
