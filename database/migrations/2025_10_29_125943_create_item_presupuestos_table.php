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
        Schema::create('item_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->references('id')->on('presupuestos');
            $table->foreignId('categoria_id')->references('id')->on('categorias');
            $table->foreignId('producto_id')->references('id')->on('productos');
            $table->text('descripcion')->nullable();
            $table->integer('cantidad')->nullable();
            $table->float('precio_unitario')->nullable();
            $table->float('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_presupuestos');
    }
};
