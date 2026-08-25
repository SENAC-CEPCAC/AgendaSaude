<?php

namespace App\Http\Controllers;

use App\Models\Cronograma;
use Illuminate\Http\Request;

class AgendamentoEtapa2Controller extends Controller
{
    /**
     * Exibe a Etapa 2 do agendamento (Seleção de Data e Horário no Calendário).
     */
    public function index(Request $request)
    {
        $dados_etapa_1 = session('agendamento.etapa_1', []);

        // Busca cronogramas com vagas disponíveis para a unidade e exame selecionados
        $query_cronogramas = Cronograma::with(['unidade', 'turno', 'vaga']);

        if (!empty($dados_etapa_1['id_cnes_unidade'])) {
            $query_cronogramas->where('id_cnes_unidade', $dados_etapa_1['id_cnes_unidade']);
        }

        if (!empty($dados_etapa_1['id_vagas'])) {
            $query_cronogramas->where('Vagas_id_vagas', $dados_etapa_1['id_vagas']);
        }

        $cronogramas_disponiveis = $query_cronogramas->get();
        $dados_etapa_2 = session('agendamento.etapa_2', []);

        return view('fluxo_agendamento.etapa_2', [
            'dados_etapa_1' => $dados_etapa_1,
            'dados_etapa_2' => $dados_etapa_2,
            'cronogramas_disponiveis' => $cronogramas_disponiveis,
        ]);
    }

    /**
     * Valida e salva os dados da Etapa 2 na sessão antes de avançar para o upload.
     */
    public function salvar_etapa_2(Request $request)
    {
        $dados_validados = $request->validate([
            'id_agenda' => 'nullable|integer',
            'data_selecionada' => 'required|date',
            'horario_selecionado' => 'required|string',
        ], [
            'data_selecionada.required' => 'Selecione uma data no calendário.',
            'horario_selecionado.required' => 'Escolha um horário de atendimento disponível.',
        ]);

        // Se id_agenda não veio explicitamente, busca o cronograma correspondente
        if (empty($dados_validados['id_agenda'])) {
            $dados_etapa_1 = session('agendamento.etapa_1', []);
            $cronograma = Cronograma::where('data_atendimento', $dados_validados['data_selecionada'])
                ->when(!empty($dados_etapa_1['id_cnes_unidade']), function ($q) use ($dados_etapa_1) {
                    $q->where('id_cnes_unidade', $dados_etapa_1['id_cnes_unidade']);
                })
                ->when(!empty($dados_etapa_1['id_vagas']), function ($q) use ($dados_etapa_1) {
                    $q->where('Vagas_id_vagas', $dados_etapa_1['id_vagas']);
                })
                ->first();

            $dados_validados['id_agenda'] = $cronograma ? $cronograma->id_agenda : 1;
        }

        session(['agendamento.etapa_2' => $dados_validados]);

        return redirect()->route('agendamento.etapa3');
    }
}
