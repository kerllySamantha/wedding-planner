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
        Schema::create('pedir_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nombre')->nullable();
            $table->foreignId('boda_id')->nullable()->constrained()->nullOnDelete();
            $table->string('telefono');
            $table->text('mensaje');
            $table->integer('invitados');
            $table->float('presupuesto', 2);
            $table->string('email');
            $table->date('fecha')->nullable();
            $table->string('estado')->default('pendiente');
            $table->decimal('importe_ofertado', 10, 2)->nullable();
            $table->text('comentario_empresa')->nullable();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedir_presupuestos');
    }
};
