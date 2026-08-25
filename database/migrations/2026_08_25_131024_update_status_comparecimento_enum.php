<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Se estiver usando MySQL:
        DB::statement("ALTER TABLE fato_prontuario MODIFY COLUMN status_comparecimento ENUM('agendado', 'confirmado', 'espera', 'presente', 'atrasado', 'nao_compareceu', 'faltou', 'cancelado') DEFAULT 'agendado'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE fato_prontuario MODIFY COLUMN status_comparecimento ENUM('agendado', 'confirmado', 'espera', 'presente', 'faltou', 'cancelado') DEFAULT 'agendado'");
    }
};