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
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boda_id')->references('id')->on('bodas');
            // $table->string('nombre')->nullable();
            // $table->text('descripcion')->nullable();
            $table->foreignId('tipo_producto_id')->nullable()->references('id')->on('tipo_productos');
            $table->float('monto_total');
            $table->boolean('estado')->default(false);
            $table->date('fecha_creacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
    }
};
