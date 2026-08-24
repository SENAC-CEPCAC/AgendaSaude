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
        Schema::table('anamnese_siscolo', function (Blueprint $table) {
            $table->string('sinais_dst', 30)->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anamnese_siscolo', function (Blueprint $table) {
            $table->boolean('sinais_dst')->nullable()->default(false)->change();
        });
    }
};