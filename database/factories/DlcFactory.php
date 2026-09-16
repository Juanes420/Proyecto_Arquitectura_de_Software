<?php

namespace Database\Factories;

use App\Models\Dlc;
use App\Models\VideoJuego;
use Illuminate\Database\Eloquent\Factories\Factory;

class DlcFactory extends Factory
{
    protected $model = Dlc::class;

    public function definition(): array
    {
        $prefijos = ['Expansion:', 'DLC:', 'Pack:'];
        $nombres = ['Season Pass', 'Ultimate Edition', 'Battle Royale', 'New Horizons', 'The Awakening', 'Lost Chapters', 'Blood Moon', 'Frozen Lands'];

        return [
            'videojuego_id' => VideoJuego::factory(),
            'nombre' => fake()->randomElement($prefijos) . ' ' . fake()->randomElement($nombres),
            'descripcion' => fake()->sentence(8),
            'precio' => fake()->randomFloat(2, 4.99, 29.99),
            'fecha_lanzamiento' => fake()->dateTimeBetween('-1 year', '+6 months'),
        ];
    }
}
