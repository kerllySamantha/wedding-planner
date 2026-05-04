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
            Schema::table('perfil_usuarios', function (Blueprint $table) {
                $table->foreignId('poblacion_id')->references('id')->on('poblaciones')->cascadeOnDelete();
                // $table->enum('novios', ['novia','novio' ]);
                $table->date('fecha_boda');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perfils', function (Blueprint $table) {
            $table->dropColumn(['poblacion_id','fecha_boda']);
        });
    }
};
