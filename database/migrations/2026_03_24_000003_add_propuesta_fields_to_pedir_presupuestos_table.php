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
            $table->foreignId('producto_id')
                ->nullable()
                ->after('reserva_id')
                ->constrained('productos')
                ->nullOnDelete();

            $table->string('modalidad')->nullable()->after('producto_id');
            $table->dateTime('fecha_inicio')->nullable()->after('fecha');
            $table->dateTime('fecha_fin')->nullable()->after('fecha_inicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedir_presupuestos', function (Blueprint $table) {
            $table->dropForeign(['producto_id']);
            $table->dropColumn([
                'producto_id',
                'modalidad',
                'fecha_inicio',
                'fecha_fin',
            ]);
        });
    }
};
