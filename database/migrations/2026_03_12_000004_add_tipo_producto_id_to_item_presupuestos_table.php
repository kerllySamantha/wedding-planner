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
        Schema::table('item_presupuestos', function (Blueprint $table) {
            $table->foreignId('tipo_producto_id')->constrained('tipo_productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_presupuestos', function (Blueprint $table) {
            $table->dropForeign(['tipo_producto_id']);
            $table->dropColumn('tipo_producto_id');
        });
    }
};
