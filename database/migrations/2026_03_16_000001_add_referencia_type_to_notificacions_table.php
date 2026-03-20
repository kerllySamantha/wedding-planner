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
        Schema::table('notificacions', function (Blueprint $table) {
            $table->string('referencia_type')->nullable()->after('referencia_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notificacions', function (Blueprint $table) {
            $table->dropColumn('referencia_type');
        });
    }
};
