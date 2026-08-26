<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Torna 'cpf_paciente' opcional na tabela 'users'.
     *
     * Motivo: nem todo usuário do sistema é um paciente (administradores,
     * médicos, gestores, etc. também usam essa tabela via 'nivel'), então
     * essa coluna não pode ser obrigatória.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('cpf_paciente', 11)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('cpf_paciente', 11)->nullable(false)->change();
        });
    }
};