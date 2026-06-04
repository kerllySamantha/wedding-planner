<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->enum('modalidad', ['producto', 'servicio', 'dia'])->nullable()->after('descripcion');
        });

        // Rellenar modalidad desde el tipo_producto asociado
        DB::statement("
            UPDATE productos p
            JOIN tipo_productos tp ON tp.id = p.tipo_producto_id
            SET p.modalidad = tp.modalidad
            WHERE p.modalidad IS NULL
        ");
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('modalidad');
        });
    }
};
