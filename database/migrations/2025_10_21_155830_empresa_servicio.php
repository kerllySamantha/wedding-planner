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
        // Schema::create('empresa_servicio', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        //     $table->foreignId('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('empresas', function (Blueprint $table) {
        //     Schema::dropIfExists('empresa_servicio');
        // });
    }
};
