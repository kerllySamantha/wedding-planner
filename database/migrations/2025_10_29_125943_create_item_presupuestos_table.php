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
            // $table->foreignId('categoria_id')->nullable()->references('id')->on('categorias');
            // $table->foreignId('tipo_producto_id')->references('id')->on('tipo_productos');
            // $table->string('nombre_categoria_personalizada')->nullable();
            $table->string('nombre_tipo_personalizado')->nullable();
            $table->integer('precio_unitario');
            $table->integer('cantidad');
            $table->integer('total_item');
            $table->boolean('es_personalizado')->nullable()->default(false);
            $table->text('notas')->nullable();
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
