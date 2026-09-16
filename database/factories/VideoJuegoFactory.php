<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\VideoJuego;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoJuegoFactory extends Factory
{
    protected $model = VideoJuego::class;

    public function definition(): array
    {
        $plataformas = ['PC', 'PlayStation 5', 'Xbox Series X', 'Nintendo Switch', 'PlayStation 4'];
        $titulos = [
            'Shadow of the Colossus', 'Neon Drift', 'Cyber Realm', 'Dragon Quest Legacy',
            'Steel Horizon', 'Mystic Valley', 'Star Vanguard', 'Pixel Warriors',
            'Frost Empire', 'Blade Runner 2099', 'Ocean Depths', 'Thunder Strike',
            'Galaxy Wanderer', 'Crimson Blade', 'Wind Chaser', 'Dark Nexus',
            'Iron Legion', 'Crystal Caverns', 'Void Walker', 'Ember Fall',
        ];

        return [
            'titulo' => fake()->unique()->randomElement($titulos),
            'plataforma' => fake()->randomElement($plataformas),
            'precio' => fake()->randomFloat(2, 9.99, 69.99),
            'stock' => fake()->numberBetween(0, 200),
            'categoria_id' => Categoria::factory(),
            'descripcion' => fake()->paragraph(3),
            'imagen' => null,
        ];
    }
}
