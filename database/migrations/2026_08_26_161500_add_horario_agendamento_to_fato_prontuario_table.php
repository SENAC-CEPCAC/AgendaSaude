<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona o campo de horário exato do exame na tabela fato_prontuario.
     */
    public function up(): void
    {
        Schema::table('fato_prontuario', function (Blueprint $table) {
            if (!Schema::hasColumn('fato_prontuario', 'horario_agendamento')) {
                $table->string('horario_agendamento', 50)->nullable()->after('id_agenda');
            }
        });
    }

    /**
     * Reverte a migration.
     */
    public function down(): void
    {
        Schema::table('fato_prontuario', function (Blueprint $table) {
            if (Schema::hasColumn('fato_prontuario', 'horario_agendamento')) {
                $table->dropColumn('horario_agendamento');
            }
        });
    }
};
