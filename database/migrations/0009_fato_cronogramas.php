<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'fato_cronogramas'.
     * 2. DEFINA 'id_agenda' COMO CHAVE PRIMÁRIA.
     * 3. ADICIONE AS CHAVES ESTRANGEIRAS 'id_cnes_unidade', 'Vagas_id_vagas' E 'Turno_id_turno'.
     * 4. ADICIONE DADOS DA AGENDA: 'data_atendimento', 'municipio_atendimento', 'qnt_oferecidas_vagas', 'prenchida_vagas'.
     */
    public function up(): void
    {
        Schema::create('fato_cronogramas', function (Blueprint $table) {
            
            $table->increments('id_agenda');

            $table->unsignedInteger('id_cnes_unidade');

            $table->foreign('id_cnes_unidade')
                    ->references('id_cnes_unidade')
                    ->on('dim_cnes_unidades')
                    ->onDelete('cascade');

            $table->unsignedInteger('Vagas_id_vagas');

            $table->foreign('Vagas_id_vagas')
                    ->references('id_vagas')
                    ->on('dim_vagas')
                    ->onDelete('cascade');

            $table->unsignedInteger('Turno_id_turno');

            $table->foreign('Turno_id_turno')
                    ->references('id_turno')
                    ->on('dim_turno')
                    ->onDelete('cascade');

            $table->date('data_atendimento');
            $table->string('municipio_atendimento', 100);
            $table->integer('qnt_oferecidas_vagas');
            $table->integer('prenchida_vagas')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fato_cronogramas');
    }
};
