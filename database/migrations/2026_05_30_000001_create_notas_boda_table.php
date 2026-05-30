<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notas_boda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boda_id')->constrained('bodas')->cascadeOnDelete();
            $table->string('titulo')->nullable();
            $table->text('contenido');
            $table->string('categoria')->default('otros');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas_boda');
    }
};
