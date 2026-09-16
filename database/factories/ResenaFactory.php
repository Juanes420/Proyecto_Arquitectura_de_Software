<?php

namespace Database\Factories;

use App\Models\Resena;
use App\Models\User;
use App\Models\VideoJuego;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResenaFactory extends Factory
{
    protected $model = Resena::class;

    private static array $comentarios = [
        'Excelente juego, lo recomiendo totalmente. La historia y los gráficos son increíbles.',
        'Buen juego pero le falta contenido. Esperaba más misiones y un mundo más grande.',
        'Me encantó la jugabilidad y los controles. Muy intuitivo y divertido desde el inicio.',
        'Regular, hay mejores opciones en el mercado. No vale lo que cuesta sinceramente.',
        'Increíble experiencia, vale cada peso. Las mecánicas de combate son muy satisfactorias.',
        'La historia es muy buena pero los controles podrían mejorar bastante.',
        'Muy divertido para jugar con amigos. El modo cooperativo es lo mejor del juego.',
        'Los gráficos son espectaculares, de lo mejor que he visto este año.',
        'Demasiado corto para el precio, lo terminé en un fin de semana.',
        'Adictivo, no puedo parar de jugarlo. Llevo más de 100 horas y sigo descubriendo cosas.',
        'Buena banda sonora y ambientación. Te sumerge completamente en el universo del juego.',
        'Le faltan actualizaciones y correcciones de errores. Tiene mucho potencial desperdiciado.',
        'Perfecto para pasar el rato, no es muy exigente pero entretiene mucho.',
        'El mejor juego que he comprado este año, sin duda alguna.',
        'Tiene algunos bugs pero en general es una experiencia muy disfrutable.',
    ];

    public function definition(): array
    {
        return [
            'usuario_id' => User::factory(),
            'videojuego_id' => VideoJuego::factory(),
            'calificacion' => fake()->numberBetween(1, 5),
            'comentario' => fake()->randomElement(self::$comentarios),
        ];
    }
}
