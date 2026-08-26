<?php

namespace App\Http\Controllers;

use App\Models\CnesUnidade;
use App\Models\Cronograma;
use App\Models\Prontuario;
use App\Models\Turno;
use App\Models\Vaga;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgendamentoEtapa2Controller extends Controller
{
    /**
     * Exibe a Etapa 2 do agendamento (Seleção de Data e Horário no Calendário).
     * O paciente SOMENTE pode selecionar datas que possuam cronogramas cadastrados pelo gestor no banco.
     * Dias sem vagas disponíveis ocultam a grade de horários e exibem o card da Lista de Espera Inteligente.
     */
    public function index(Request $request)
    {
        $dados_etapa_1 = session('agendamento.etapa_1', []);
        $id_cnes_unidade = !empty($dados_etapa_1['id_cnes_unidade']) ? (int) $dados_etapa_1['id_cnes_unidade'] : null;
        $id_vagas = !empty($dados_etapa_1['id_vagas']) ? (int) $dados_etapa_1['id_vagas'] : null;

        // 1. Garante existência prévia das tabelas dimensionais
        if (Vaga::count() === 0) {
            Vaga::updateOrCreate(['id_vagas' => 1], ['tipo_exame' => 'Preventivo (Siscolo)']);
            Vaga::updateOrCreate(['id_vagas' => 2], ['tipo_exame' => 'Mamografia (Sismama)']);
        }
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
        if (Turno::count() === 0) {
            Turno::updateOrCreate(['id_turno' => 1], ['turno' => 'Manhã']);
            Turno::updateOrCreate(['id_turno' => 2], ['turno' => 'Tarde']);
            Turno::updateOrCreate(['id_turno' => 3], ['turno' => 'Integral']);
        }

        // 2. Busca cronogramas cadastrados pelo Gestor
        $query = Cronograma::with(['unidade', 'turno', 'vaga', 'prontuarios']);
        if ($id_vagas) {
            $query->where('Vagas_id_vagas', $id_vagas);
        }
        if ($id_cnes_unidade) {
            $query->where('id_cnes_unidade', $id_cnes_unidade);
        }

        $cronogramas = $query->orderBy('data_atendimento', 'asc')->get();

        // Se não houver cronograma na unidade escolhida, tenta em outras unidades —
        // mas NUNCA abandona o filtro de tipo de exame (isso trocaria a escolha do paciente sem avisar)
        if ($cronogramas->isEmpty() && $id_cnes_unidade && $id_vagas) {
            $cronogramas = Cronograma::with(['unidade', 'turno', 'vaga', 'prontuarios'])
                ->where('Vagas_id_vagas', $id_vagas)
                ->orderBy('data_atendimento', 'asc')
                ->get();
        }

        // 3. Determina o mês/ano de exibição do calendário
        $mesAnoParam = $request->input('mes_ano');
        if (!empty($mesAnoParam)) {
            $dataBase = Carbon::parse($mesAnoParam . '-01');
        } elseif ($cronogramas->isNotEmpty()) {
            $dataBase = Carbon::parse($cronogramas->first()->data_atendimento);
        } else {
            $dataBase = now();
        }

        $mesAtual = $dataBase->format('Y-m');
        $nomeMesAno = $dataBase->translatedFormat('F \d\e Y');
        $primeiroDiaMes = $dataBase->copy()->startOfMonth();
        $ultimoDiaMes = $dataBase->copy()->endOfMonth();
        $diaSemanaInicio = $primeiroDiaMes->dayOfWeek; // 0 = Domingo, 1 = Segunda, ...

        // 4. Monta o mapa de disponibilidade por data (YYYY-MM-DD)
        $mapaCronogramas = [];

        foreach ($cronogramas as $crono) {
            $dataStr = Carbon::parse($crono->data_atendimento)->format('Y-m-d');
            $vagasTotais = (int) $crono->qnt_oferecidas_vagas;
            $vagasPreenchidas = (int) $crono->prenchida_vagas;
            $vagasRestantes = max(0, $vagasTotais - $vagasPreenchidas);
            $esgotado = ($vagasRestantes === 0);

            // Grade de horários base conforme o turno
            $turnoId = (int) $crono->Turno_id_turno;
            $gradeHorarios = [];

            if ($turnoId === 1) { // Manhã
                $gradeHorarios = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30'];
            } elseif ($turnoId === 2) { // Tarde
                $gradeHorarios = ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'];
            } else { // Integral
                $gradeHorarios = [
                    '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                    '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'
                ];
            }

            // Bloqueio de horários já agendados
            $horariosComStatus = [];
            foreach ($gradeHorarios as $index => $hora) {
                $estaOcupado = ($index < $vagasPreenchidas) || $esgotado;
                $horariosComStatus[] = [
                    'horario' => $hora,
                    'ocupado' => $estaOcupado,
                ];
            }

            $mapaCronogramas[$dataStr] = [
                'id_agenda' => $crono->id_agenda,
                'data' => $dataStr,
                'data_formatada' => Carbon::parse($crono->data_atendimento)->translatedFormat('d \d\e F \d\e Y'),
                'turno_nome' => $crono->turno?->turno ?? 'Manhã',
                'vagas_totais' => $vagasTotais,
                'vagas_preenchidas' => $vagasPreenchidas,
                'vagas_restantes' => $vagasRestantes,
                'esgotado' => $esgotado,
                'horarios' => $horariosComStatus,
            ];
        }

        // Data inicialmente selecionada
        $primeiraDataDisponivel = null;
        foreach ($mapaCronogramas as $dt => $info) {
            if (!$info['esgotado']) {
                $primeiraDataDisponivel = $dt;
                break;
            }
        }
        if (!$primeiraDataDisponivel && !empty($mapaCronogramas)) {
            $primeiraDataDisponivel = array_key_first($mapaCronogramas);
        }

        $dados_etapa_2 = session('agendamento.etapa_2', []);
        $dataSelecionada = !empty($dados_etapa_2['data_selecionada']) && isset($mapaCronogramas[$dados_etapa_2['data_selecionada']])
            ? $dados_etapa_2['data_selecionada']
            : ($primeiraDataDisponivel ?? now()->format('Y-m-d'));

        $cronogramaSelecionado = $mapaCronogramas[$dataSelecionada] ?? null;

        // Verifica se o paciente logado já está em alguma lista de espera ativa
        $pacienteJaTemEspera = false;
        $usuario = auth()->user();
        if ($usuario) {
            $cpfLimpo = preg_replace('/\D/', '', (string) ($usuario->cpf_paciente ?? $usuario->cpf ?? ''));
            if ($cpfLimpo) {
                $pacienteJaTemEspera = Prontuario::where('cpf_paciente', $cpfLimpo)
                    ->where('status_comparecimento', 'espera')
                    ->exists();
            }
        }

        return view('fluxo_agendamento.etapa_2', [
            'dados_etapa_1' => $dados_etapa_1,
            'dados_etapa_2' => $dados_etapa_2,
            'cronogramas' => $cronogramas,
            'mapaCronogramas' => $mapaCronogramas,
            'dataBase' => $dataBase,
            'mesAtual' => $mesAtual,
            'nomeMesAno' => $nomeMesAno,
            'primeiroDiaMes' => $primeiroDiaMes,
            'ultimoDiaMes' => $ultimoDiaMes,
            'diaSemanaInicio' => $diaSemanaInicio,
            'dataSelecionada' => $dataSelecionada,
            'cronogramaSelecionado' => $cronogramaSelecionado,
            'pacienteJaTemEspera' => $pacienteJaTemEspera,
        ]);
    }

    /**
     * Valida e salva os dados da Etapa 2 na sessão antes de avançar para o upload.
     * Aplica a regra: Cada paciente pode participar de no máximo 1 dia de lista de espera.
     */
    public function salvar_etapa_2(Request $request)
    {
        $dados_validados = $request->validate([
            'id_agenda' => 'required|integer|exists:fato_cronogramas,id_agenda',
            'data_selecionada' => 'required|date',
            'horario_selecionado' => 'required|string',
        ], [
            'id_agenda.required' => 'Selecione um dia disponível no calendário.',
            'id_agenda.exists' => 'O dia selecionado não possui cronograma de vagas ativo.',
            'data_selecionada.required' => 'Selecione uma data no calendário.',
            'horario_selecionado.required' => 'Escolha um horário de atendimento disponível ou opte pela Lista de Espera.',
        ]);

        $cronograma = Cronograma::findOrFail($dados_validados['id_agenda']);
        $vagasRestantes = max(0, (int)$cronograma->qnt_oferecidas_vagas - (int)$cronograma->prenchida_vagas);
        $ehEspera = ($vagasRestantes === 0) || in_array($dados_validados['horario_selecionado'], ['Lista de Espera', 'Fila de Espera'], true);

        // Regra de Negócio: Limite de 1 dia de Lista de Espera por paciente
        if ($ehEspera) {
            $usuario = auth()->user();
            $cpf = $usuario?->cpf_paciente ?? $usuario?->cpf;
            if ($cpf) {
                $cpfLimpo = preg_replace('/\D/', '', (string) $cpf);
                $jaTemEspera = Prontuario::where('cpf_paciente', $cpfLimpo)
                    ->where('status_comparecimento', 'espera')
                    ->exists();

                if ($jaTemEspera) {
                    return back()->withInput()->withErrors([
                        'limite_espera' => 'Você já possui uma inscrição ativa na Lista de Espera Inteligente. Cada paciente pode participar da lista de espera de apenas 1 data por vez.'
                    ]);
                }
            }

            $dados_validados['tipo_agendamento'] = 'espera';
            $dados_validados['horario_selecionado'] = 'Lista de Espera';
        } else {
            $dados_validados['tipo_agendamento'] = 'titular';
        }

        session(['agendamento.etapa_2' => $dados_validados]);

        return redirect()->route('agendamento.etapa3');
    }
}