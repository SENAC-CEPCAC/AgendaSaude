<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona colunas para controle e upload de documentos na tabela 'fato_prontuario'.
     * - caminho_documento_rg_cpf: caminho do arquivo de identificação (máx 5MB).
     * - caminho_documento_requisicao: caminho do arquivo de requisição médica (opcional).
     * - status_documento: status da triagem N1 ('pendente', 'aprovado', 'rejeitado').
     * - motivo_rejeicao_documento: mensagem orientando o paciente/operador em caso de reanexação.
     */
    public function up(): void
    {
        Schema::table('fato_prontuario', function (Blueprint $table) {
            $table->string('caminho_documento_rg_cpf', 255)->nullable()->after('status_comparecimento');
            $table->string('caminho_documento_requisicao', 255)->nullable()->after('caminho_documento_rg_cpf');
            $table->enum('status_documento', ['pendente', 'aprovado', 'validar_no_ato', 'rejeitado'])->default('pendente')->after('caminho_documento_requisicao');
            $table->string('motivo_rejeicao_documento', 255)->nullable()->after('status_documento');
        });
    }

    /**
     * Reverte as alterações da migration.
     */
    public function down(): void
    {
        Schema::table('fato_prontuario', function (Blueprint $table) {
            $table->dropColumn([
                'caminho_documento_rg_cpf',
                'caminho_documento_requisicao',
                'status_documento',
                'motivo_rejeicao_documento'
            ]);
        });
    }
};
