<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'dim_cnes_unidades'.
     * 2. DEFINA 'id_cnes_unidade' COMO CHAVE PRIMÁRIA AUTOINCREMENTÁVEL.
     * 3. ADICIONE 'codigo_cnes' (VARCHAR 20) E 'nome_unidade' (VARCHAR 150).
     * 4. DEFINA 'criado_em' / TIMESTAMPS.
     */
    public function up(): void
    {
        Schema::create('dim_cnes_unidades', function (Blueprint $table) {

            $table->increments('id_cnes_unidade');
            $table->string('codigo_cnes', 20)->unique();
            $table->string('nome_unidade', 150);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_cnes_unidades');
    }
};
