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
     * O paciente pode selecionar datas que possuam cronogramas cadastrados pelo gestor no banco.
     * Gera a quantidade exata de horários correspondente às vagas cadastradas.
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

        // Se o banco não possuir nenhum cronograma, cria cronogramas automáticos para o mês atual
        if (Cronograma::count() === 0) {
            $dataBaseSeed = now();
            for ($d = 0; $d < 25; $d++) {
                $diaCrono = $dataBaseSeed->copy()->addDays($d);
                if (!$diaCrono->isWeekend()) {
                    Cronograma::create([
                        'id_cnes_unidade' => 1,
                        'Vagas_id_vagas' => 1, // Preventivo
                        'Turno_id_turno' => 1, // Manhã
                        'data_atendimento' => $diaCrono->format('Y-m-d'),
                        'municipio_atendimento' => 'Salvador - Centro',
                        'qnt_oferecidas_vagas' => 20,
                        'prenchida_vagas' => 0,
                    ]);
                    Cronograma::create([
                        'id_cnes_unidade' => 1,
                        'Vagas_id_vagas' => 2, // Mamografia
                        'Turno_id_turno' => 2, // Tarde
                        'data_atendimento' => $diaCrono->format('Y-m-d'),
                        'municipio_atendimento' => 'Salvador - Centro',
                        'qnt_oferecidas_vagas' => 20,
                        'prenchida_vagas' => 0,
                    ]);
                }
            }
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

        // Se não houver cronograma na unidade escolhida, busca por tipo de exame em outras unidades
        if ($cronogramas->isEmpty() && $id_vagas) {
            $cronogramas = Cronograma::with(['unidade', 'turno', 'vaga', 'prontuarios'])
                ->where('Vagas_id_vagas', $id_vagas)
                ->orderBy('data_atendimento', 'asc')
                ->get();
        }

        // Se ainda assim estiver vazio, busca todos os cronogramas cadastrados
        if ($cronogramas->isEmpty()) {
            $cronogramas = Cronograma::with(['unidade', 'turno', 'vaga', 'prontuarios'])
                ->orderBy('data_atendimento', 'asc')
                ->get();
        }

        // 3. Determina o mês/ano de exibição do calendário
        $mesAnoParam = $request->input('mes_ano');
        if (!empty($mesAnoParam)) {
            $dataBase = Carbon::parse($mesAnoParam . '-01');
        } elseif ($cronogramas->isNotEmpty()) {
            // Foca no primeiro cronograma a partir de hoje (ou no primeiro cadastrado)
            $primeiroFuturo = $cronogramas->first(function ($c) {
                return Carbon::parse($c->data_atendimento)->isToday() || Carbon::parse($c->data_atendimento)->isFuture();
            });
            $dataBase = $primeiroFuturo 
                ? Carbon::parse($primeiroFuturo->data_atendimento) 
                : Carbon::parse($cronogramas->first()->data_atendimento);
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
            $vagasTotais = max(1, (int) $crono->qnt_oferecidas_vagas);
            
            // Busca agendamentos reais efetuados no banco para este cronograma
            $agendadosReais = Prontuario::where('id_agenda', $crono->id_agenda)
                ->whereIn('status_comparecimento', ['agendado', 'confirmado', 'presente'])
                ->get();

            $totalAgendadosReais = $agendadosReais->count();
            
            // Sincroniza a contagem real de vagas preenchidas
            $vagasPreenchidas = $totalAgendadosReais;
            if ((int) $crono->prenchida_vagas !== $vagasPreenchidas) {
                $crono->prenchida_vagas = $vagasPreenchidas;
                $crono->save();
            }

            $vagasRestantes = max(0, $vagasTotais - $vagasPreenchidas);
            $esgotado = ($vagasRestantes === 0);

            // Grade com a QUANTIDADE EXATA de horários correspondente às vagas cadastradas
            $turnoId = (int) $crono->Turno_id_turno;
            $gradeHorarios = $this->gerarGradeHorarios($turnoId, $vagasTotais);

            // Horários já reservados por outros pacientes reais
            $horariosReservados = $agendadosReais
                ->pluck('horario_agendamento')
                ->filter()
                ->toArray();

            // Monta cada horário com seu status de disponibilidade
            $horariosComStatus = [];
            foreach ($gradeHorarios as $index => $hora) {
                // Está ocupado se o horário já foi nominalmente reservado OU se o número de reservas cobriu este slot
                $estaOcupado = in_array($hora, $horariosReservados, true) || ($index < $vagasPreenchidas) || $esgotado;

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

        // Data inicialmente selecionada: prioriza a primeira data com vagas disponíveis
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

        // Horário inicial pré-selecionado
        $horarioInicial = '08:00';
        if ($cronogramaSelecionado && !$cronogramaSelecionado['esgotado']) {
            foreach ($cronogramaSelecionado['horarios'] as $h) {
                if (!$h['ocupado']) {
                    $horarioInicial = $h['horario'];
                    break;
                }
            }
        } elseif ($cronogramaSelecionado && $cronogramaSelecionado['esgotado']) {
            $horarioInicial = 'Lista de Espera';
        }

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
            'horarioInicial' => $horarioInicial,
            'pacienteJaTemEspera' => $pacienteJaTemEspera,
        ]);
    }

    /**
     * Gera exatamente a quantidade de horários correspondente às vagas cadastradas no cronograma.
     */
    private function gerarGradeHorarios(int $turnoId, int $quantidadeVagas): array
    {
        $quantidadeVagas = max(1, $quantidadeVagas);
        $horarios = [];

        if ($turnoId === 1) {
            // Turno Manhã: 08:00 às 12:00 (240 minutos)
            $inicioMin = 8 * 60; // 480
            $intervalo = $quantidadeVagas > 1 ? floor(240 / $quantidadeVagas) : 0;

            for ($i = 0; $i < $quantidadeVagas; $i++) {
                $minutos = $inicioMin + ($i * $intervalo);
                $h = str_pad((string) floor($minutos / 60), 2, '0', STR_PAD_LEFT);
                $m = str_pad((string) ($minutos % 60), 2, '0', STR_PAD_LEFT);
                $horarios[] = "{$h}:{$m}";
            }
        } elseif ($turnoId === 2) {
            // Turno Tarde: 13:00 às 17:00 (240 minutos)
            $inicioMin = 13 * 60; // 780
            $intervalo = $quantidadeVagas > 1 ? floor(240 / $quantidadeVagas) : 0;

            for ($i = 0; $i < $quantidadeVagas; $i++) {
                $minutos = $inicioMin + ($i * $intervalo);
                $h = str_pad((string) floor($minutos / 60), 2, '0', STR_PAD_LEFT);
                $m = str_pad((string) ($minutos % 60), 2, '0', STR_PAD_LEFT);
                $horarios[] = "{$h}:{$m}";
            }
        } else {
            // Turno Integral: Manhã (08:00 - 12:00) e Tarde (13:00 - 17:00)
            $vagasManha = (int) ceil($quantidadeVagas / 2);
            $vagasTarde = $quantidadeVagas - $vagasManha;

            // Manhã
            $inicioMinM = 8 * 60;
            $intervaloM = $vagasManha > 1 ? floor(240 / $vagasManha) : 0;
            for ($i = 0; $i < $vagasManha; $i++) {
                $minutos = $inicioMinM + ($i * $intervaloM);
                $h = str_pad((string) floor($minutos / 60), 2, '0', STR_PAD_LEFT);
                $m = str_pad((string) ($minutos % 60), 2, '0', STR_PAD_LEFT);
                $horarios[] = "{$h}:{$m}";
            }

            // Tarde
            $inicioMinT = 13 * 60;
            $intervaloT = $vagasTarde > 1 ? floor(240 / $vagasTarde) : 0;
            for ($i = 0; $i < $vagasTarde; $i++) {
                $minutos = $inicioMinT + ($i * $intervaloT);
                $h = str_pad((string) floor($minutos / 60), 2, '0', STR_PAD_LEFT);
                $m = str_pad((string) ($minutos % 60), 2, '0', STR_PAD_LEFT);
                $horarios[] = "{$h}:{$m}";
            }
        }

        return $horarios;
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