<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Dlc;
use App\Models\Pedido;
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

        $tarjetas = Tarjeta::all();
        $estados = ['pendiente', 'procesando', 'completado', 'cancelado'];

        $clientes->random(min(6, $clientes->count()))->each(function ($cliente) use ($videojuegos, $tarjetas, $estados) {
            $numPedidos = rand(1, 3);
            for ($i = 0; $i < $numPedidos; $i++) {
                $pedido = Pedido::create([
                    'usuario_id' => $cliente->id,
                    'fecha' => now()->subDays(rand(1, 60)),
                    'estado' => $estados[array_rand($estados)],
                    'total' => 0,
                ]);

                $total = 0;
                $juegosDelPedido = $videojuegos->random(min(rand(1, 3), $videojuegos->count()));
                foreach ($juegosDelPedido as $juego) {
                    $cantidad = rand(1, 2);
                    $pedido->detalles()->create([
                        'videojuego_id' => $juego->id,
                        'cantidad' => $cantidad,
                        'precio_unit' => $juego->precio,
                    ]);
                    $total += $juego->precio * $cantidad;
                }

                if ($tarjetas->count() && rand(0, 1)) {
                    $tarjeta = $tarjetas->random();
                    $cantidad = rand(1, 2);
                    $pedido->detalles()->create([
                        'tarjeta_id' => $tarjeta->id,
                        'cantidad' => $cantidad,
                        'precio_unit' => $tarjeta->precio,
                    ]);
                    $total += $tarjeta->precio * $cantidad;
                }

                $pedido->update(['total' => $total]);
            }
        });
    }
}
