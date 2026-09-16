<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisitos_minimos_pc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('videojuego_id')->constrained('videojuegos')->onDelete('cascade');
            $table->string('sistema_operativo');
            $table->string('procesador');
            $table->string('memoria_ram');
            $table->string('tarjeta_grafica');
            $table->string('almacenamiento');
            $table->string('directx')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisitos_minimos_pc');
    }
};
