<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('reservas', function (Blueprint $table) {

            // Cambiar fecha a fecha_inicio con hora
                $table->dateTime('fecha_inicio')->nullable()->after('boda_id');
                $table->dateTime('fecha_fin')->nullable()->after('fecha_inicio');
                $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'bloqueada'])
                ->default('pendiente')
                ->change();
            $table->enum('origen', ['usuario', 'proveedor'])->default('proveedor')->after('estado');
            $table->text('notas')->nullable()->after('origen');
            // $table->foreignId('servicio_id')->nullable()->references('id')->on('servicios')->after('notas');
            // $table->foreignId('producto_id')->nullable()->constrained('productos')->after('servicio_id');
        });
    }

    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_inicio',
                'fecha_fin',
                'origen',
                'notas',
                
            ]);
        });
    }
};
