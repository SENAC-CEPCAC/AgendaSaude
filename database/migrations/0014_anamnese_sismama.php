<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'anamnese_sismama'.
     * 2. DEFINA 'id_sismama' COMO CHAVE PRIMÁRIA.
     * 3. VINCULE 'id_fato_anamnese' (BIGINT) COM 'fato_anamnese'.
     * 4. ADICIONE AS RESPOSTAS DO PROTOCOLO SISMAMA (NÓDULOS, RISCO, EXAMES PRÉVIOS, ACHADOS CLÍNICOS).
     */
    public function up(): void
    {
        Schema::create('anamnese_sismama', function (Blueprint $table) {
            
            $table->increments('id_sismama');

            $table->unsignedBigInteger('id_fato_anamnese');

            $table->foreign('id_fato_anamnese')
                    ->references('id_fato_anamnese')
                    ->on('fato_anamnese')
                    ->onDelete('cascade');

            $table->boolean('nodulo_mama_direita')->default(false);
            $table->boolean('nodulo_mama_esquerda')->default(false);
            $table->boolean('risco_elevado_cancer')->default(false);
            $table->boolean('mamas_examinadas_anteriormente')->default(false);
            $table->boolean('fez_mamografia_anterior')->default(false);
            $table->integer('ano_ultima_mamografia')->nullable();
            $table->boolean('fez_radioterapia_mama')->default(false);
            $table->boolean('fez_cirurgia_mama')->default(false);
            $table->string('tipo_mamografia', 100)->nullable();
            $table->string('achado_descarga_papilar_dir', 100)->nullable();
            $table->string('achado_descarga_papilar_esq', 100)->nullable();
            $table->string('achado_nodulo_localizacao_dir', 100)->nullable();
            $table->string('achado_nodulo_localizacao_esq', 100)->nullable();
            $table->string('achado_linfonodo_palpavel_dir', 100)->nullable();
            $table->string('achado_linfonodo_palpavel_esq', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anamnese_sismama');
    }
};
