<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition(): array
    {
        $categorias = ['Acción', 'Aventura', 'RPG', 'Deportes', 'Estrategia', 'Simulación', 'Horror', 'Puzzle', 'Plataformas', 'Carreras'];

        return [
            'nombre' => fake()->unique()->randomElement($categorias),
            'descripcion' => fake()->sentence(10),
        ];
    }
}
