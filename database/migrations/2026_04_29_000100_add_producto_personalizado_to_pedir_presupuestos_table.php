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
            $table->string('producto_personalizado_nombre')->nullable()->after('producto_id');
            $table->boolean('es_producto_personalizado')->default(false)->after('producto_personalizado_nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedir_presupuestos', function (Blueprint $table) {
            $table->dropColumn(['producto_personalizado_nombre', 'es_producto_personalizado']);
        });
    }
};

