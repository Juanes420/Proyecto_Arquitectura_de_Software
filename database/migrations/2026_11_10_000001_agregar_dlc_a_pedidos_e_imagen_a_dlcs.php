<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dlcs', function (Blueprint $table) {
            $table->string('imagen')->nullable()->after('precio');
        });

        Schema::table('detalle_pedidos', function (Blueprint $table) {
            $table->foreignId('dlc_id')->nullable()->after('tarjeta_id')->constrained('dlcs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('detalle_pedidos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dlc_id');
        });

        Schema::table('dlcs', function (Blueprint $table) {
            $table->dropColumn('imagen');
        });
    }
};
