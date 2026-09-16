<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    private static array $descripciones = [
        'Acción' => 'Juegos de ritmo rápido con combate, disparos y adrenalina constante.',
        'Aventura' => 'Explora mundos, resuelve acertijos y vive historias épicas.',
        'RPG' => 'Juegos de rol con progresión de personajes, misiones y narrativa profunda.',
        'Deportes' => 'Simulaciones deportivas de fútbol, baloncesto, carreras y más.',
        'Estrategia' => 'Planifica, construye y conquista con tácticas y gestión de recursos.',
        'Simulación' => 'Experiencias realistas de vida, negocios, vuelo y construcción.',
        'Horror' => 'Suspenso, terror y supervivencia en ambientes oscuros e inquietantes.',
        'Puzzle' => 'Desafíos mentales, rompecabezas y juegos de lógica.',
        'Plataformas' => 'Salta, corre y supera obstáculos en niveles llenos de acción.',
        'Carreras' => 'Velocidad, competencia y adrenalina sobre ruedas.',
    ];

    public function definition(): array
    {
        $nombre = fake()->unique()->randomElement(array_keys(self::$descripciones));

        return [
            'nombre' => $nombre,
            'descripcion' => self::$descripciones[$nombre],
        ];
    }
}
