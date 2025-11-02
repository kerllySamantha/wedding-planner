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
        Schema::create('bodas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->unique()->nullable()->constrained('users')->onDelete('cascade'); 
            $table->string('nombre_pareja'); 
            // $table->foreignId('boda_user_id')->references('id')->on('users');
            $table->date('fecha_boda'); 
            $table->string('ubicacion');
            $table->json('fotos')->nullable();
            $table->decimal('presupuesto_total', 10, 2)->nullable(); 
            $table->text('notas')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bodas');
    }
};