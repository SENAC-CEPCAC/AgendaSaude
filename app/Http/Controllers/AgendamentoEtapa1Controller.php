<?php

namespace App\Http\Controllers;

use App\Models\CnesUnidade;
use App\Models\Vaga;
use Illuminate\Http\Request;

class AgendamentoEtapa1Controller extends Controller
{
    /**
     * Exibe a Etapa 1 do agendamento (Seleção de Exame e Unidade Móvel).
     */
    public function index()
    {
        // Busca todas as unidades móveis cadastradas
        $unidades_moveis = CnesUnidade::all();

        // Busca os tipos de exames disponíveis (Siscolo / Sismama)
        $tipos_exames = Vaga::all();

        // Recupera seleções prévias da sessão (se o paciente estiver voltando ou editando)
        $dados_etapa_1 = session('agendamento.etapa_1', []);

        return view('fluxo_agendamento.etapa_1', [
            'unidades_moveis' => $unidades_moveis,
            'tipos_exames' => $tipos_exames,
            'dados_etapa_1' => $dados_etapa_1,
        ]);
    }

    /**
     * Valida e salva os dados da Etapa 1 na sessão antes de avançar.
     */
    public function salvar_etapa_1(Request $request)
    {
        $dados_validados = $request->validate([
            'id_cnes_unidade' => 'required|integer',
            'id_vagas' => 'required|integer',
        ], [
            'id_cnes_unidade.required' => 'Selecione uma unidade móvel para continuar.',
            'id_vagas.required' => 'Selecione o tipo de exame desejado.',
        ]);

        // Salva as escolhas na sessão do agendamento
        session(['agendamento.etapa_1' => $dados_validados]);

        return redirect()->route('agendamento.etapa2');
    }
}
