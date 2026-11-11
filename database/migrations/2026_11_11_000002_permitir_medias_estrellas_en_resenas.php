<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Las resenas pasan de 1-5 enteros a 0,5-5 en medias estrellas; los valores actuales se conservan.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resenas', function (Blueprint $table) {
            $table->decimal('calificacion', 2, 1)->change();
        });
    }

    public function down(): void
    {
        Schema::table('resenas', function (Blueprint $table) {
            $table->unsignedTinyInteger('calificacion')->change();
        });
    }
};
