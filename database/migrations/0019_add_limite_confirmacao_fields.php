<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fato_prontuario', function (Blueprint $table) {
            if (! Schema::hasColumn('fato_prontuario', 'limite_confirmacao_24h')) {
                $table->dateTime('limite_confirmacao_24h')->nullable();
            }
            if (! Schema::hasColumn('fato_prontuario', 'cliente_confirmou')) {
                $table->boolean('cliente_confirmou')->nullable();
            }
            if (! Schema::hasColumn('fato_prontuario', 'numero_sequencial')) {
                $table->unsignedBigInteger('numero_sequencial')->nullable();
            }
            if (! Schema::hasColumn('fato_prontuario', 'status_agendamento')) {
                $table->string('status_agendamento', 50)->default('em_espera');
            }
            if (! Schema::hasColumn('fato_prontuario', 'status_documentos')) {
                $table->enum('status_documentos', ['pendente', 'aprovado', 'validar_no_ato', 'rejeitado'])->default('pendente');
            }
        });
    }

    public function down(): void
    {
        $columns = array_filter([
            'limite_confirmacao_24h',
            'cliente_confirmou',
            'numero_sequencial',
            'status_agendamento',
            'status_documentos',
        ], fn (string $column): bool => Schema::hasColumn('fato_prontuario', $column));

        if ($columns) {
            Schema::table('fato_prontuario', function (Blueprint $table) use ($columns): void {
                $table->dropColumn($columns);
            });
        }
    }
};

