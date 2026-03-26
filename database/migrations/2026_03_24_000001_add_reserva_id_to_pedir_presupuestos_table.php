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
            $table->foreignId('reserva_id')
                ->nullable()
                ->after('id')
                ->constrained('reservas')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedir_presupuestos', function (Blueprint $table) {
            $table->dropForeign(['reserva_id']);
            $table->dropColumn('reserva_id');
        });
    }
};
