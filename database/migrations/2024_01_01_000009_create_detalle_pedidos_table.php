<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('videojuego_id')->nullable()->constrained('videojuegos')->onDelete('set null');
            $table->foreignId('tarjeta_id')->nullable()->constrained('tarjetas')->onDelete('set null');
            $table->unsignedInteger('cantidad')->default(1);
            $table->decimal('precio_unit', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
