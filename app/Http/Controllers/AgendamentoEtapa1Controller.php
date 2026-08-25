<?php

namespace App\Http\Controllers;

use App\Models\CnesUnidade;
use App\Models\Vaga;
use App\Models\Turno;
use Illuminate\Http\Request;

class AgendamentoEtapa1Controller extends Controller
{
    /**
     * Exibe a Etapa 1 do agendamento (Seleção de Exame e Unidade Móvel).
     */
    public function index()
    {
        // Garante a existência dos tipos de exames básicos (dim_vagas)
        if (Vaga::count() === 0) {
            Vaga::updateOrCreate(['id_vagas' => 1], ['tipo_exame' => 'Preventivo (Siscolo)']);
            Vaga::updateOrCreate(['id_vagas' => 2], ['tipo_exame' => 'Mamografia (Sismama)']);
        }

        // Garante a existência das unidades móveis básicas (dim_cnes_unidades)
        if (CnesUnidade::count() === 0) {
            CnesUnidade::updateOrCreate(
                ['codigo_cnes' => '2658914'],
                ['nome_unidade' => 'Unidade Móvel de Saúde da Mulher 01 - Centro / Itinerante']
            );
            CnesUnidade::updateOrCreate(
                ['codigo_cnes' => '3049182'],
                ['nome_unidade' => 'Unidade Móvel de Prevenção e Diagnóstico 02 - Zona Leste']
            );
        }

        // Garante turnos básicos (dim_turno)
        if (Turno::count() === 0) {
            Turno::updateOrCreate(['id_turno' => 1], ['turno' => 'Manhã']);
            Turno::updateOrCreate(['id_turno' => 2], ['turno' => 'Tarde']);
            Turno::updateOrCreate(['id_turno' => 3], ['turno' => 'Integral']);
        }

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
