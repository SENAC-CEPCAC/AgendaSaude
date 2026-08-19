<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class VerificarPrazo24hAgendamentos extends Command
{
    protected $signature = 'agendamentos:verificar-prazo-24h';
    protected $description = 'Verifica agendamentos com prazo de 24h expirado';

    public function handle()
    {
        // Proteção: verifica se a migration já foi executada
        if (!Schema::hasColumn('fato_prontuario', 'limite_confirmacao_24h')) {
            $this->error('A coluna "limite_confirmacao_24h" ainda nao existe na tabela fato_prontuario. Execute php artisan migrate.');
            return Command::FAILURE;
        }

        $agora = Carbon::now();

        $expirados = DB::table('fato_prontuario')
            ->where(function($q) {
                $q->where('status_agendamento', 'aguardando_confirmacao')
                  ->orWhere('status_comparecimento', 'aguardando_confirmacao');
            })
            ->where('limite_confirmacao_24h', '<=', $agora)
            ->whereNull('cliente_confirmou')
            ->get();

        if ($expirados->isEmpty()) {
            $this->info('Nenhum agendamento expirado no momento.');
            return Command::SUCCESS;
        }

        foreach ($expirados as $agendamento) {
            DB::table('fato_prontuario')
                ->where('id_prontuario', $agendamento->id_prontuario)
                ->update([
                    'status_comparecimento' => 'cancelado',
                    'status_agendamento' => 'cancelado_prazo_24h',
                    'updated_at' => $agora
                ]);

            $this->warn("Agendamento #{$agendamento->id_prontuario} cancelado por falta de confirmacao em 24h.");
        }

        return Command::SUCCESS;
    }
}