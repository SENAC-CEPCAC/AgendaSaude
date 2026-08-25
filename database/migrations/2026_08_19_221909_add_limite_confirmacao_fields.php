<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('fato_prontuario', function (Blueprint $table) {
        $table->dateTime('limite_confirmacao_24h')->nullable();
        $table->boolean('cliente_confirmou')->nullable();
        $table->unsignedBigInteger('numero_sequencial')->nullable();
        $table->string('status_agendamento', 50)->default('em_espera');
        $table->enum('status_documentos', ['pendente', 'aprovado', 'validar_no_ato', 'rejeitado'])->default('pendente');
    });
}
};

