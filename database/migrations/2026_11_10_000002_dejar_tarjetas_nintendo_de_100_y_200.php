<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Las tarjetas de Nintendo solo se venden de $100 y $200. Las demas no se borran (pueden estar en pedidos): quedan sin stock.
return new class extends Migration
{
    public function up(): void
    {
        $nintendo = DB::table('tarjetas')->where('plataforma', 'Nintendo')->orderBy('id')->get();

        foreach ([100, 200] as $indice => $monto) {
            $datos = ['nombre' => "Nintendo eShop \${$monto}", 'precio' => $monto, 'updated_at' => now()];
            $tarjeta = $nintendo->get($indice);

            if ($tarjeta) {
                DB::table('tarjetas')->where('id', $tarjeta->id)->update($datos);
            } else {
                DB::table('tarjetas')->insert($datos + [
                    'plataforma' => 'Nintendo',
                    'stock' => 50,
                    'descripcion' => 'Tarjeta de regalo digital para comprar juegos y contenido en la tienda.',
                    'created_at' => now(),
                ]);
            }
        }

        $sobrantes = $nintendo->slice(2)->pluck('id');

        if ($sobrantes->isNotEmpty()) {
            DB::table('tarjetas')->whereIn('id', $sobrantes)->update(['stock' => 0, 'updated_at' => now()]);
        }
    }

    public function down(): void {}
};
