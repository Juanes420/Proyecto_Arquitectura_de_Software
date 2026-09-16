<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\VideoJuego;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoJuegoFactory extends Factory
{
    protected $model = VideoJuego::class;

    private static array $descripciones = [
        'Un mundo abierto lleno de aventuras, misiones secundarias y secretos por descubrir en cada rincón del mapa.',
        'Combate táctico en tiempo real con un sistema de habilidades profundo y personalizable para cada clase.',
        'Explora mazmorras generadas proceduralmente mientras mejoras tu equipo y desbloqueas nuevas habilidades.',
        'Una historia emotiva sobre amistad y sacrificio ambientada en un universo de ciencia ficción.',
        'Acción frenética con gráficos de última generación y una banda sonora épica que acompaña cada momento.',
        'Construye tu imperio desde cero, gestiona recursos y defiende tu territorio de invasores.',
        'Carreras de alta velocidad con personalización completa de vehículos y circuitos en todo el mundo.',
        'Supervivencia en un mundo postapocalíptico donde cada decisión cuenta y los recursos son escasos.',
        'Plataformas en 3D con mecánicas innovadoras, niveles coloridos y jefes memorables.',
        'Terror psicológico con una atmósfera inmersiva que te mantendrá al borde del asiento.',
        'Estrategia por turnos con más de 50 unidades diferentes y campañas multijugador competitivas.',
        'Simulador de vida con actividades como pesca, agricultura, cocina y construcción de tu hogar ideal.',
    ];

    public function definition(): array
    {
        $plataformas = ['PC', 'PlayStation 5', 'Xbox Series X', 'Nintendo Switch', 'PlayStation 4'];
        $titulos = [
            'Shadow of the Colossus', 'Neon Drift', 'Cyber Realm', 'Dragon Quest Legacy',
            'Steel Horizon', 'Mystic Valley', 'Star Vanguard', 'Pixel Warriors',
            'Frost Empire', 'Blade Runner 2099', 'Ocean Depths', 'Thunder Strike',
            'Galaxy Wanderer', 'Crimson Blade', 'Wind Chaser', 'Dark Nexus',
            'Iron Legion', 'Crystal Caverns', 'Void Walker', 'Ember Fall',
            'Astral Gate', 'Rune Forge', 'Venom Strike', 'Titan Core',
            'Phantom Edge', 'Solar Flare', 'Night Stalker', 'Arcane Pulse',
            'Doom Spire', 'Echo Prime', 'Savage Lands', 'Quantum Rift',
        ];

        return [
            'titulo' => fake()->unique()->randomElement($titulos),
            'plataforma' => fake()->randomElement($plataformas),
            'precio' => fake()->randomFloat(2, 9.99, 69.99),
            'stock' => fake()->numberBetween(0, 200),
            'categoria_id' => Categoria::factory(),
            'descripcion' => fake()->randomElement(self::$descripciones),
            'imagen' => null,
        ];
    }
}
