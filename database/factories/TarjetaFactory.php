<?php

namespace Database\Factories;

use App\Models\Tarjeta;
use Illuminate\Database\Eloquent\Factories\Factory;

class TarjetaFactory extends Factory
{
    protected $model = Tarjeta::class;

    public function definition(): array
    {
        $nombres = ['PlayStation Store $10', 'PlayStation Store $25', 'PlayStation Store $50',
            'Xbox Gift Card $15', 'Xbox Gift Card $25', 'Xbox Gift Card $50',
            'Nintendo eShop $20', 'Nintendo eShop $35', 'Nintendo eShop $50',
            'Steam Wallet $20', 'Steam Wallet $50', 'Steam Wallet $100'];

        return [
            'nombre' => fake()->unique()->randomElement($nombres),
            'plataforma' => fake()->randomElement(['PlayStation', 'Xbox', 'Nintendo', 'Steam']),
            'precio' => fake()->randomElement([10, 15, 20, 25, 35, 50, 100]),
            'stock' => fake()->numberBetween(5, 100),
            'descripcion' => fake()->sentence(6),
            'imagen' => null,
        ];
    }
}
