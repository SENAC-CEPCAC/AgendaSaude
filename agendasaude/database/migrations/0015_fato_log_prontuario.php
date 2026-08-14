<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'fato_log_prontuario'.
     * 2. DEFINA 'id_log' COMO BIGINT.
     * 3. VINCULE 'id_profissional' COM 'dim_profissionais'.
     * 4. ADICIONE 'tipo_operacao' (ENUM: 'criacao', 'leitura', 'atualizacao', 'exclusao'), 'ip_origem' E 'data_hora'.
     */
    public function up(): void
    {
        Schema::create('fato_log_prontuario', function (Blueprint $table) {

            $table->bigIncrements('id_log');

            $table->unsignedInteger('id_profissional');
            
            $table->foreign('id_profissional')
                    ->references('id_profissional')
                    ->on('dim_profissionais')
                    ->onDelete('cascade');

            $table->enum('tipo_operacao', ['criacao', 'leitura', 'atualizacao', 'exclusao']);
            $table->string('ip_origem', 45);
            $table->dateTime('data_hora')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fato_log_prontuario');
    }
};
