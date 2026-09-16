<?php

namespace Database\Factories;

use App\Models\Resena;
use App\Models\User;
use App\Models\VideoJuego;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResenaFactory extends Factory
{
    protected $model = Resena::class;

    public function definition(): array
    {
        return [
            'usuario_id' => User::factory(),
            'videojuego_id' => VideoJuego::factory(),
            'calificacion' => fake()->numberBetween(1, 5),
            'comentario' => fake()->paragraph(2),
        ];
    }
}
