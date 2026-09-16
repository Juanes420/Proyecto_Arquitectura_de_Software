<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    private static array $nombres = [
        'Carlos Martínez', 'María López', 'Andrés García', 'Laura Rodríguez',
        'Santiago Hernández', 'Valentina Torres', 'Sebastián Ramírez', 'Camila Flores',
        'Mateo Gómez', 'Isabella Díaz', 'Daniel Morales', 'Sofía Vargas',
        'Alejandro Rojas', 'Mariana Castro', 'Nicolás Ortiz', 'Paula Jiménez',
    ];

    public function definition(): array
    {
        return [
            'nombre' => fake()->randomElement(self::$nombres),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'cliente',
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
}
