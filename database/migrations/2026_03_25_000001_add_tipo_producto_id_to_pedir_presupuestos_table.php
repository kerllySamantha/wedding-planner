<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedir_presupuestos', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_producto_id')
                ->nullable()
                ->after('empresa_id')
                ->index();
            $table->foreign('tipo_producto_id')
                ->references('id')
                ->on('tipo_productos')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedir_presupuestos', function (Blueprint $table) {
            $table->dropForeign(['tipo_producto_id']);
            $table->dropColumn('tipo_producto_id');
        });
    }
};
