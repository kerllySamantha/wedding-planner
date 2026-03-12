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
            $table->decimal('monto_estimado', 10, 2)->default(0);
            $table->decimal('monto_pagado', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_presupuestos', function (Blueprint $table) {
            $table->dropColumn(['monto_estimado', 'monto_pagado']);
        });
    }
};
