<?php

namespace App\Services\ProductosAliados;

use App\Contracts\ProductosAliadosService;

class ProductosAliadosLocal implements ProductosAliadosService
{
    public function obtener(): array
    {
        return [
            [
                'nombre' => 'Sitio web corporativo',
                'descripcion' => 'Página institucional con diseño a la medida y panel de administración.',
                'precio' => 1500000,
                'imagen' => null,
                'enlace' => null,
            ],
            [
                'nombre' => 'Tienda en línea',
                'descripcion' => 'Comercio electrónico con catálogo, carrito y pasarela de pagos.',
                'precio' => 3200000,
                'imagen' => null,
                'enlace' => null,
            ],
            [
                'nombre' => 'App de reservas',
                'descripcion' => 'Aplicación para agendar citas con recordatorios por correo.',
                'precio' => 2400000,
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
