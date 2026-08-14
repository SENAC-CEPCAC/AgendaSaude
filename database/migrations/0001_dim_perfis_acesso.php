<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'dim_perfis_acesso'.
     * 2. DEFINA 'id_perfil' COMO CHAVE PRIMÁRIA AUTOINCREMENTÁVEL (INT).
     * 3. ADICIONE A COLUNA 'nome_perfil' (VARCHAR 50).
     * 4. ADICIONE A COLUNA 'pode_ver_anamnese' (BOOLEAN/TINYINT) COM PADRÃO FALSO.
     * 5. ADICIONE 'created_at' E 'updated_at'.
     */
    public function up(): void
    {
        Schema::create('dim_perfis_acesso', function (Blueprint $table) {

            $table->increments('id_perfil');
            $table->string('nome_perfil', 50);
            $table->boolean('pode_ver_anamnese')->default(false);
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dim_perfis_acesso');
    }
};