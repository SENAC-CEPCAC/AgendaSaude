<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'dim_pacientes'.
     * 2. DEFINA 'id_paciente' COMO CHAVE PRIMÁRIA.
     * 3. ADICIONE DOCUMENTOS: 'cartao_sus' (VARCHAR 15), 'cpf' (CHAR 11).
     * 4. ADICIONE NOMES: 'nome_completo' (VARCHAR 150), 'nome_mae' (VARCHAR 150), 'apelido' (VARCHAR 50).
     * 5. ADICIONE DADOS DEMOGRÁFICOS: 'data_nascimento', 'sexo' (CHAR 1), 'raca_cor' (VARCHAR 20), 'escolaridade' (VARCHAR 50).
     * 6. ADICIONE TERMO LGPD 'termo_lgpd_aceito' (BOOLEAN) E 'data_cadastro'.
     */
    public function up(): void
    {
        Schema::create('dim_pacientes', function (Blueprint $table) {
            // DADOS PESSOAIS
            $table->increments('id_paciente');
            $table->string('cartao_sus', 15)->nullable();
            $table->char('cpf', 11)->unique();
            $table->string('nome_completo', 150);
            $table->string('nome_mae', 150)->nullable();
            $table->string('apelido', 50)->nullable();
            $table->date('data_nascimento');
            //DADOS SENSIVEIS
            $table->char('sexo', 1);
            $table->string('raca_cor', 20)->nullable();
            $table->string('escolaridade', 50)->nullable();
            
            $table->boolean('termo_lgpd_aceito')->default(false);
            $table->dateTime('data_cadastro')->useCurrent();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_pacientes');
    }
};
