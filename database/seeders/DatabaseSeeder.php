<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Dlc;
use App\Models\Resena;
use App\Models\Tarjeta;
use App\Models\User;
use App\Models\VideoJuego;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'nombre' => 'Admin GameVault',
            'email' => 'admin@gamevault.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $clientes = User::factory(10)->create(['role' => 'cliente']);

        $categorias = Categoria::factory(8)->create();

        $videojuegos = collect();
        foreach ($categorias as $categoria) {
            $juegos = VideoJuego::factory(rand(2, 3))->create([
                'categoria_id' => $categoria->id,
            ]);
            $videojuegos = $videojuegos->merge($juegos);
        }

        $videojuegos->random(min(8, $videojuegos->count()))->each(function ($juego) {
            Dlc::factory(rand(1, 3))->create([
                'videojuego_id' => $juego->id,
            ]);
        });

        Tarjeta::factory(10)->create();

        $clientes->each(function ($cliente) use ($videojuegos) {
            $juegosResenados = $videojuegos->random(min(3, $videojuegos->count()));
            foreach ($juegosResenados as $juego) {
                Resena::factory()->create([
                    'usuario_id' => $cliente->id,
                    'videojuego_id' => $juego->id,
                ]);
            }
        });

        $clientes->each(function ($cliente) use ($videojuegos) {
            $juegosWishlist = $videojuegos->random(min(rand(1, 5), $videojuegos->count()));
            foreach ($juegosWishlist as $juego) {
                Wishlist::firstOrCreate([
                    'usuario_id' => $cliente->id,
                    'videojuego_id' => $juego->id,
                ]);
            }
        });
    }
}
