<?php

namespace Database\Factories;

use App\Models\Tarjeta;
use Illuminate\Database\Eloquent\Factories\Factory;

class TarjetaFactory extends Factory
{
    protected $model = Tarjeta::class;

    private static array $tarjetas = [
        ['nombre' => 'PlayStation Store $10', 'plataforma' => 'PlayStation', 'precio' => 10],
        ['nombre' => 'PlayStation Store $25', 'plataforma' => 'PlayStation', 'precio' => 25],
        ['nombre' => 'PlayStation Store $50', 'plataforma' => 'PlayStation', 'precio' => 50],
        ['nombre' => 'Xbox Gift Card $15', 'plataforma' => 'Xbox', 'precio' => 15],
        ['nombre' => 'Xbox Gift Card $25', 'plataforma' => 'Xbox', 'precio' => 25],
        ['nombre' => 'Xbox Gift Card $50', 'plataforma' => 'Xbox', 'precio' => 50],
        ['nombre' => 'Nintendo eShop $20', 'plataforma' => 'Nintendo', 'precio' => 20],
        ['nombre' => 'Nintendo eShop $35', 'plataforma' => 'Nintendo', 'precio' => 35],
        ['nombre' => 'Nintendo eShop $50', 'plataforma' => 'Nintendo', 'precio' => 50],
        ['nombre' => 'Steam Wallet $20', 'plataforma' => 'Steam', 'precio' => 20],
        ['nombre' => 'Steam Wallet $50', 'plataforma' => 'Steam', 'precio' => 50],
        ['nombre' => 'Steam Wallet $100', 'plataforma' => 'Steam', 'precio' => 100],
    ];

    private static array $descripciones = [
        'Tarjeta de regalo digital para comprar juegos y contenido en la tienda.',
        'Codigo canjeable para agregar saldo a tu cuenta de la plataforma.',
        'Tarjeta prepago para compras en linea de juegos, DLCs y suscripciones.',
    ];

    public function definition(): array
    {
        $tarjeta = fake()->unique()->randomElement(self::$tarjetas);

        return [
            'nombre' => $tarjeta['nombre'],
            'plataforma' => $tarjeta['plataforma'],
            'precio' => $tarjeta['precio'],
            'stock' => fake()->numberBetween(5, 100),
            'descripcion' => fake()->randomElement(self::$descripciones),
            'imagen' => null,
        ];
    }
}
