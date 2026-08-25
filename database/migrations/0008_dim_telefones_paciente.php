<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'dim_telefones_paciente'.
     * 2. DEFINA 'id_telefone' COMO CHAVE PRIMÁRIA.
     * 3. VINCULE 'cpf_paciente' À TABELA 'dim_pacientes'.
     * 4. ADICIONE 'numero' (VARCHAR 20) E 'tipo' (ENUM: 'celular', 'residencial', 'recado').
     */
    public function up(): void
    {
        Schema::create('dim_telefones_paciente', function (Blueprint $table) {
            $table->increments('id_telefone');

            $table->char('cpf_paciente', 11);
            $table->foreign('cpf_paciente')
                    ->references('cpf_paciente')
                    ->on('dim_pacientes')
                    ->onDelete('cascade');

            $table->string('numero', 20);
            $table->enum('tipo', ['celular', 'residencial', 'recado'])->default('celular');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_telefones_paciente');
    }
};
