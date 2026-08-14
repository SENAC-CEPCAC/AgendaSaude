<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'dim_turno'.
     * 2. DEFINA 'id_turno' COMO CHAVE PRIMÁRIA AUTOINCREMENTÁVEL.
     * 3. ADICIONE 'turno' (VARCHAR 45).
     */
    public function up(): void
    {
        Schema::create('dim_turno', function (Blueprint $table) {

            $table->increments('id_turno');
            $table->string('turno', 45);
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dim_turno');
    }
};
