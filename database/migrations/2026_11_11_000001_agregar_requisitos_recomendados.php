<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const COLUMNAS = ['sistema_operativo', 'procesador', 'memoria_ram', 'tarjeta_grafica', 'almacenamiento', 'directx'];

    public function up(): void
    {
        Schema::table('requisitos_minimos_pc', function (Blueprint $table) {
            foreach (self::COLUMNAS as $columna) {
                $table->string($columna . '_recomendado')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('requisitos_minimos_pc', function (Blueprint $table) {
            $table->dropColumn(array_map(fn ($columna) => $columna . '_recomendado', self::COLUMNAS));
        });
    }
};
