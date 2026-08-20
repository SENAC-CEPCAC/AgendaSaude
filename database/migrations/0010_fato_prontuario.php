<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'fato_prontuario'.
     * 2. DEFINA 'id_prontuario' COMO CHAVE PRIMÁRIA.
     * 3. VINCULE 'id_paciente' COM 'dim_pacientes' E 'id_agenda' COM 'fato_cronogramas'.
     * 4. ADICIONE 'status_comparecimento' (ENUM: 'agendado', 'presente', 'faltou', 'cancelado').
     */
    public function up(): void
    {
        Schema::create('fato_prontuario', function (Blueprint $table) {

            $table->increments('id_prontuario');

            $table->unsignedInteger('id_paciente');
            
            $table->foreign('id_paciente')
                    ->references('id_paciente')
                    ->on('dim_pacientes')
                    ->onDelete('cascade');

            $table->unsignedInteger('id_agenda');

            $table->foreign('id_agenda')
                    ->references('id_agenda')
                    ->on('fato_cronogramas')
                    ->onDelete('cascade');

            $table->enum('status_comparecimento', [
                'agendado',       // Vaga titular confirmada no agendamento inicial
                'confirmado',     // Respondeu ao WhatsApp confirmando presença
                'espera',         // Entrou na lista de espera inteligente (vagas cheias)
                'presente',       // Chegou na unidade móvel
                'faltou',         // Não compareceu
                'cancelado'       // Desistiu / vaga liberada para o próximo
            ])->default('agendado');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fato_prontuario');
    }
};
