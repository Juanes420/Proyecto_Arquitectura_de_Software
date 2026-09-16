<?php

namespace Database\Factories;

use App\Models\Dlc;
use App\Models\VideoJuego;
use Illuminate\Database\Eloquent\Factories\Factory;

class DlcFactory extends Factory
{
    protected $model = Dlc::class;

    private static array $nombres = [
        'Pase de Temporada', 'Edicion Definitiva', 'Nuevos Horizontes',
        'El Despertar', 'Capitulos Perdidos', 'Luna de Sangre',
        'Tierras Heladas', 'Mundo Sumergido', 'Sombras del Pasado',
        'Arena Eterna', 'Reinos Olvidados', 'Furia del Dragon',
    ];

    private static array $descripciones = [
        'Contenido adicional con nuevas misiones, armas y zonas por explorar.',
        'Expansion que agrega una nueva historia completa con mas de 10 horas de juego.',
        'Pack de personajes y skins exclusivas para el modo multijugador.',
        'Nuevos niveles desafiantes con jefes unicos y recompensas especiales.',
        'Contenido cosmético con trajes, monturas y accesorios temáticos.',
        'Modo de juego adicional con ranking competitivo y temporadas.',
    ];

    public function definition(): array
    {
        return [
            'videojuego_id' => VideoJuego::factory(),
            'nombre' => fake()->randomElement(self::$nombres),
            'descripcion' => fake()->randomElement(self::$descripciones),
            'precio' => fake()->randomFloat(2, 4.99, 29.99),
            'fecha_lanzamiento' => fake()->dateTimeBetween('-1 year', '+6 months'),
        ];
    }
}
