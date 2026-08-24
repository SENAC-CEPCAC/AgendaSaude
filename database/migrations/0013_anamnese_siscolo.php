<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'anamnese_siscolo'.
     * 2. DEFINA 'id_siscolo' COMO CHAVE PRIMÁRIA.
     * 3. VINCULE 'id_fato_anamnese' (BIGINT) COM 'fato_anamnese'.
     * 4. ADICIONE AS RESPOSTAS DO PROTOCOLO SISCOLO (PREVENTIVO, DIU, GRAVIDEZ, PÍLULA, SANGRAMENTOS, ETC.).
     */
    public function up(): void
    {
        Schema::create('anamnese_siscolo', function (Blueprint $table) {
            
            $table->increments('id_siscolo');

            $table->unsignedBigInteger('id_fato_anamnese');

            $table->foreign('id_fato_anamnese')
                    ->references('id_fato_anamnese')
                    ->on('fato_anamnese')
                    ->onDelete('cascade');

            $table->string('motivo_exame', 50)->nullable();
            $table->boolean('fez_preventivo_anterior')->default(false);
            $table->integer('ano_ultimo_preventivo')->nullable();
            $table->boolean('usa_diu')->default(false);
            $table->boolean('esta_gravida')->default(false);
            $table->boolean('usa_pilula')->default(false);
            $table->boolean('usa_hormonio_menopausa')->default(false);
            $table->boolean('ja_fez_radioterapia')->default(false);
            $table->date('data_ultima_menstruacao')->nullable();
            $table->boolean('sangramento_apos_relacao')->default(false);
            $table->boolean('sangramento_apos_menopausa')->default(false);
            $table->string('inspecao_colo')->nullable();
            $table->boolean('sinais_dst')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anamnese_siscolo');
    }
};
