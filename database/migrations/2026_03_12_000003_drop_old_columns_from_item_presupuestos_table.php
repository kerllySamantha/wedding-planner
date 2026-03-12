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
        Schema::table('item_presupuestos', function (Blueprint $table) {
            $table->dropColumn(['precio_unitario', 'cantidad', 'total_item']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_presupuestos', function (Blueprint $table) {
            $table->integer('precio_unitario')->default(0);
            $table->integer('cantidad')->default(1);
            $table->integer('total_item')->default(0);
        });
    }
};
