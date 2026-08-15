<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'dim_vagas'.
     * 2. DEFINA 'id_vagas' COMO CHAVE PRIMÁRIA AUTOINCREMENTÁVEL.
     * 3. ADICIONE 'tipo_exame' (VARCHAR 45).
     */
    public function up(): void
    {
        Schema::create('dim_vagas', function (Blueprint $table) {

            $table->increments('id_vagas');
            $table->string('tipo_exame', 45);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_vagas');
    }
};
