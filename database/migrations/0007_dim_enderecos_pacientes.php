<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'dim_enderecos_pacientes'.
     * 2. DEFINA 'id_endereco' COMO CHAVE PRIMÁRIA.
     * 3. VINCULE 'id_paciente' À TABELA 'dim_pacientes'.
     * 4. ADICIONE CAMPOS DE ENDEREÇO (LOGRADOURO, NÚMERO, BAIRRO, MUNICÍPIO, UF, CEP, PONTO DE REFERÊNCIA).
     */
    public function up(): void
    {
        Schema::create('dim_enderecos_pacientes', function (Blueprint $table) {

            $table->increments('id_endereco');

            $table->unsignedInteger('id_paciente');

            $table->foreign('id_paciente')
                    ->references('id_paciente')
                    ->on('dim_pacientes')
                    ->onDelete('cascade');

            $table->string('logradouro', 200);
            $table->string('numero', 20);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 100);
            $table->string('municipio', 100);
            $table->char('uf', 2);
            $table->string('cep', 9);
            $table->string('ponto_referencia', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_enderecos_pacientes');
    }
    
};
