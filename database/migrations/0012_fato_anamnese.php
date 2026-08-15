<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'fato_anamnese'.
     * 2. DEFINA 'id_fato_anamnese' COMO BIGINT AUTOINCREMENTÁVEL.
     * 3. VINCULE 'id_prontuario' COM 'fato_prontuario' E 'id_profissional' COM 'dim_profissionais'.
     * 4. ADICIONE 'tipo_anamnese' (ENUM: 'siscolo', 'sismama') E 'data_realizacao'.
     */
    public function up(): void
    {
        Schema::create('fato_anamnese', function (Blueprint $table) {

            $table->bigIncrements('id_fato_anamnese');

            $table->unsignedInteger('id_prontuario');

            $table->foreign('id_prontuario')
                    ->references('id_prontuario')
                    ->on('fato_prontuario')
                    ->onDelete('cascade');

            $table->unsignedInteger('id_profissional');
            
            $table->foreign('id_profissional')
                    ->references('id_profissional')
                    ->on('dim_profissionais')
                    ->onDelete('cascade');

            $table->enum('tipo_anamnese', ['siscolo', 'sismama']);
            $table->date('data_realizacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fato_anamnese');
    }
};
