<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dim_pacientes', function (Blueprint $table) {
            $table->string('cartao_sus', 18)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('dim_pacientes', function (Blueprint $table) {
            $table->string('cartao_sus', 15)->nullable()->change();
        });
    }
};
