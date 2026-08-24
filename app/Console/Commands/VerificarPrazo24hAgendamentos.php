<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VerificarPrazo24hAgendamentos extends Command
{
    protected $signature = 'agendamentos:verificar-24h';
    protected $description = 'Verifica limite_confirmacao_24h em fato_prontuario, cancela faltosos e convoca próximo da fila';

    public function handle(): int
    {
        $agora = Carbon::now();
        $this->info("Iniciando rotina de verificação 24h em fato_prontuario: {$agora}");

        // Localiza agendamentos cujo prazo de 24h expirou sem confirmação
        $expirados = DB::table('fato_prontuario')
            ->where('status_agendamento', 'aguardando_confirmacao')
            ->whereNotNull('limite_confirmacao_24h')
            ->where('limite_confirmacao_24h', '<', $agora)
            ->where(function ($query) {
                $query->whereNull('cliente_confirmou')
                      ->orWhere('cliente_confirmou', false);
            })
            ->get();

        if ($expirados->isEmpty()) {
            $this->info("Nenhum agendamento expirado no momento.");
            return Command::SUCCESS;
        }

        foreach ($expirados as $prontuario) {
            $this->warn("Cancelando agendamento #{$prontuario->numero_sequencial} (CPF: {$prontuario->cpf_paciente}) por expiração de prazo 24h.");

            // 1. Marca como cancelado
            DB::table('fato_prontuario')
                ->where('id_prontuario', $prontuario->id_prontuario)
                ->update([
                    'status_agendamento' => 'cancelado_prazo_24h',
                    'status_comparecimento' => 'cancelado',
                    'motivo_rejeicao_documento' => 'Vaga liberada automaticamente: prazo de confirmação de 24h expirado.',
                    'updated_at' => $agora,
                ]);

            // 2. Busca o próximo da fila de espera da mesma agenda
            $proximoFila = DB::table('fato_prontuario')
                ->where('status_agendamento', 'em_espera')
                ->where('id_agenda', $prontuario->id_agenda)
                ->orderBy('numero_sequencial', 'asc')
                ->first();

            if ($proximoFila) {
                $novoLimite = $agora->copy()->addHours(24);

                DB::table('fato_prontuario')
                    ->where('id_prontuario', $proximoFila->id_prontuario)
                    ->update([
                        'status_agendamento' => 'aguardando_confirmacao',
                        'limite_confirmacao_24h' => $novoLimite,
                        'updated_at' => $agora,
                    ]);

                $this->info("✓ Paciente #{$proximoFila->numero_sequencial} (CPF: {$proximoFila->cpf_paciente}) promovido da fila com prazo de 24h até {$novoLimite}.");
            }
        }

        return Command::SUCCESS;
    }
}