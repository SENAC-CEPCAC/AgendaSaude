<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'fato_feedback'.
     * 2. DEFINA 'id_feedback' COMO CHAVE PRIMÁRIA.
     * 3. VINCULE 'fato_prontuario_id_prontuario' COM 'fato_prontuario'.
     * 4. ADICIONE CRITÉRIOS DE AVALIAÇÃO: 'avaliacao' (INT), TEMPO DE ESPERA, EQUIPE, CLAREZA, AGENDAMENTO.
     * 5. ADICIONE 'comentario' (VARCHAR 220).
     */
    public function up(): void
    {
        Schema::create('fato_feedback', function (Blueprint $table) {

            $table->increments('id_feedback');

            $table->unsignedInteger('fato_prontuario_id_prontuario');
            
            $table->foreign('fato_prontuario_id_prontuario')
                    ->references('id_prontuario')
                    ->on('fato_prontuario')
                    ->onDelete('cascade');

            $table->integer('avaliacao')->nullable();
            $table->string('tempo_espera', 45)->nullable();
            $table->string('atendimento_equipe', 45)->nullable();
            $table->string('clareza_informacoes', 45)->nullable();
            $table->string('facilidade_agendamento', 45)->nullable();
            $table->string('comentario', 220)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fato_feedback');
    }
};
