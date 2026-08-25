<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RelatorioController extends Controller
{
    /**
     * 1. QUERY DE PACIENTES ATENDIDOS (ÁREA OPERACIONAL)
     */
    private function getQueryAtendidos($busca = null, $dataInicio = null, $dataFim = null)
    {
        $query = DB::table('fato_prontuario as p')
            ->join('dim_pacientes as pac', 'p.cpf_paciente', '=', 'pac.cpf_paciente')
            ->join('fato_cronogramas as c', 'p.id_agenda', '=', 'c.id_agenda')
            ->leftJoin('dim_vagas as v', 'c.Vagas_id_vagas', '=', 'v.id_vagas')
            ->leftJoin('dim_turno as t', 'c.Turno_id_turno', '=', 't.id_turno')
            ->leftJoin('dim_cnes_unidades as u', 'c.id_cnes_unidade', '=', 'u.id_cnes_unidade')
            ->where(function ($q) {
                $q->whereIn('p.status_comparecimento', ['presente', 'atrasado', 'confirmado'])
                  ->orWhere('p.status_agendamento', 'confirmado');
            });

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('pac.nome_completo', 'like', "%{$busca}%")
                  ->orWhere('pac.cpf_paciente', 'like', "%{$busca}%")
                  ->orWhere('pac.cartao_sus', 'like', "%{$busca}%")
                  ->orWhere('p.numero_sequencial', 'like', "%{$busca}%")
                  ->orWhere('v.tipo_exame', 'like', "%{$busca}%");
            });
        }

        if (!empty($dataInicio) && !empty($dataFim)) {
            $query->whereBetween('c.data_atendimento', [$dataInicio, $dataFim]);
        }

        return $query->select(
            'p.id_prontuario',
            'p.numero_sequencial',
            'pac.cpf_paciente',
            'pac.nome_completo as nome_paciente',
            'pac.cartao_sus',
            'c.data_atendimento',
            'c.municipio_atendimento',
            'v.tipo_exame',
            't.turno',
            'u.nome_unidade',
            'u.codigo_cnes',
            'p.status_comparecimento',
            'p.status_documento as status_documentos'
        )->orderBy('c.data_atendimento', 'desc');
    }

    /**
     * 2. QUERY DE QUESTIONÁRIOS DE ANAMNESE (ÁREA CLÍNICA)
     */
    private function getQueryAnamneses($busca = null, $dataInicio = null, $dataFim = null, $tipoProtocolo = null)
    {
        $query = DB::table('fato_anamnese as a')
            ->join('fato_prontuario as p', 'a.id_prontuario', '=', 'p.id_prontuario')
            ->join('dim_pacientes as pac', 'p.cpf_paciente', '=', 'pac.cpf_paciente')
            ->join('dim_profissionais as prof', 'a.id_profissional', '=', 'prof.id_profissional')
            ->leftJoin('anamnese_sismama as mama', 'a.id_fato_anamnese', '=', 'mama.id_fato_anamnese')
            ->leftJoin('anamnese_siscolo as colo', 'a.id_fato_anamnese', '=', 'colo.id_fato_anamnese')
            ->leftJoin('fato_cronogramas as c', 'p.id_agenda', '=', 'c.id_agenda')
            ->leftJoin('dim_cnes_unidades as u', 'c.id_cnes_unidade', '=', 'u.id_cnes_unidade');

        if (!empty($tipoProtocolo) && in_array($tipoProtocolo, ['sismama', 'siscolo'])) {
            $query->where('a.tipo_anamnese', $tipoProtocolo);
        }

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('pac.nome_completo', 'like', "%{$busca}%")
                  ->orWhere('pac.cpf_paciente', 'like', "%{$busca}%")
                  ->orWhere('prof.nome', 'like', "%{$busca}%");
            });
        }

        if (!empty($dataInicio) && !empty($dataFim)) {
            $query->whereBetween('a.data_realizacao', [$dataInicio, $dataFim]);
        }

        return $query->select(
            'a.id_fato_anamnese',
            'a.tipo_anamnese',
            'a.data_realizacao',
            'p.id_prontuario',
            'p.numero_sequencial',
            'pac.cpf_paciente',
            'pac.nome_completo as nome_paciente',
            'pac.cartao_sus',
            'pac.data_nascimento',
            'pac.sexo',
            'prof.nome as nome_profissional',
            'prof.registro_profissional as crm',
            'prof.cargo_funcao',
            'u.nome_unidade',
            // SISMAMA
            'mama.nodulo_mama_direita',
            'mama.nodulo_mama_esquerda',
            'mama.risco_elevado_cancer',
            'mama.tipo_mamografia',
            'mama.fez_mamografia_anterior',
            'mama.ano_ultima_mamografia',
            'mama.achado_descarga_papilar_dir',
            'mama.achado_nodulo_localizacao_dir',
            'mama.achado_linfonodo_palpavel_dir',
            // SISCOLO
            'colo.motivo_exame',
            'colo.fez_preventivo_anterior',
            'colo.ano_ultimo_preventivo',
            'colo.usa_pilula',
            'colo.usa_diu',
            'colo.esta_gravida',
            'colo.inspecao_colo',
            'colo.sinais_dst'
        )->orderBy('a.data_realizacao', 'desc');
    }

    /**
     * 3. QUERY DE DESISTÊNCIAS E CANCELAMENTOS (ÁREA DE AUDITORIA)
     */
    private function getQueryDesistencias($busca = null, $dataInicio = null, $dataFim = null)
    {
        $query = DB::table('fato_prontuario as p')
            ->join('dim_pacientes as pac', 'p.cpf_paciente', '=', 'pac.cpf_paciente')
            ->leftJoin('dim_telefones_paciente as tel', 'pac.cpf_paciente', '=', 'tel.cpf_paciente')
            ->leftJoin('fato_cronogramas as c', 'p.id_agenda', '=', 'c.id_agenda')
            ->leftJoin('dim_vagas as v', 'c.Vagas_id_vagas', '=', 'v.id_vagas')
            ->where(function ($q) {
                $q->whereIn('p.status_comparecimento', ['cancelado', 'nao_compareceu', 'faltou'])
                  ->orWhere('p.status_agendamento', 'cancelado_prazo_24h')
                  ->orWhere('p.status_documento', 'rejeitado');
            });

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('pac.nome_completo', 'like', "%{$busca}%")
                  ->orWhere('pac.cpf_paciente', 'like', "%{$busca}%");
            });
        }

        if (!empty($dataInicio) && !empty($dataFim)) {
            $query->whereBetween('c.data_atendimento', [$dataInicio, $dataFim]);
        }

        return $query->select(
            'p.id_prontuario',
            'p.numero_sequencial',
            'pac.cpf_paciente',
            'pac.nome_completo as nome_paciente',
            'tel.numero as telefone',
            'c.data_atendimento',
            'p.updated_at as data_cancelamento',
            'v.tipo_exame',
            'p.status_comparecimento',
            'p.status_agendamento',
            'p.motivo_rejeicao_documento'
        )->orderBy('p.updated_at', 'desc');
    }

    /**
     * 4. QUERY DA FILA DE ESPERA (ÁREA DE VAGAS)
     */
    private function getQueryFilaEspera($busca = null)
    {
        $query = DB::table('fato_prontuario as p')
            ->join('dim_pacientes as pac', 'p.cpf_paciente', '=', 'pac.cpf_paciente')
            ->leftJoin('dim_telefones_paciente as tel', 'pac.cpf_paciente', '=', 'tel.cpf_paciente')
            ->leftJoin('fato_cronogramas as c', 'p.id_agenda', '=', 'c.id_agenda')
            ->leftJoin('dim_vagas as v', 'c.Vagas_id_vagas', '=', 'v.id_vagas')
            ->where(function ($q) {
                $q->where('p.status_agendamento', 'em_espera')
                  ->orWhere('p.status_comparecimento', 'espera');
            });

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('pac.nome_completo', 'like', "%{$busca}%")
                  ->orWhere('pac.cpf_paciente', 'like', "%{$busca}%");
            });
        }

        return $query->select(
            'p.id_prontuario',
            'p.numero_sequencial',
            'pac.cpf_paciente',
            'pac.nome_completo as nome_paciente',
            'pac.cartao_sus',
            'tel.numero as telefone',
            'p.created_at as data_entrada',
            'v.tipo_exame',
            'p.status_documento as status_documentos',
            'p.status_agendamento'
        )->orderBy('p.numero_sequencial', 'asc');
    }

    /**
     * TELA PRINCIPAL DE RELATÓRIOS
     */
    public function index(Request $request)
    {
        $tipo = $request->get('tipo', 'atendidos');
        $busca = $request->get('search');
        $dataInicio = $request->get('data_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dataFim = $request->get('data_fim', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $atendidos = $this->getQueryAtendidos($busca, $dataInicio, $dataFim)->paginate(15, ['*'], 'atendidos_page');
        $anamneses = $this->getQueryAnamneses($busca, $dataInicio, $dataFim)->paginate(15, ['*'], 'anamneses_page');
        $desistencias = $this->getQueryDesistencias($busca, $dataInicio, $dataFim)->paginate(15, ['*'], 'desistencias_page');
        $filaEspera = $this->getQueryFilaEspera($busca)->paginate(15, ['*'], 'fila_page');

        // Totalizadores independentes por área
        $totais = [
            'atendidos'    => $this->getQueryAtendidos(null, $dataInicio, $dataFim)->count(),
            'desistencias' => $this->getQueryDesistencias(null, $dataInicio, $dataFim)->count(),
            'fila_espera'  => $this->getQueryFilaEspera(null)->count(),
            'anamneses'    => $this->getQueryAnamneses(null, $dataInicio, $dataFim)->count(),
        ];

        return view('relatorios.index', compact(
            'tipo',
            'busca',
            'dataInicio',
            'dataFim',
            'atendidos',
            'anamneses',
            'desistencias',
            'filaEspera',
            'totais'
        ));
    }

    /**
     * IMPRESSÃO DE TODAS AS ANAMNESES EM PDF
     */
    public function imprimirTodasAnamneses(Request $request)
    {
        $busca = $request->get('search');
        $dataInicio = $request->get('data_inicio');
        $dataFim = $request->get('data_fim');
        $tipoProtocolo = $request->get('tipo_protocolo');

        $anamneses = $this->getQueryAnamneses($busca, $dataInicio, $dataFim, $tipoProtocolo)->get();

        return view('relatorios.imprimir-todas-anamneses', compact('anamneses'));
    }

    /**
     * EXPORTAÇÃO EM CSV POR ÁREA ESPECÍFICA (COM SUPORTE A FILTROS ATIVOS)
     */
    public function exportarCsv(Request $request, string $tipo)
    {
        $busca = $request->get('search');
        $dataInicio = $request->get('data_inicio');
        $dataFim = $request->get('data_fim');

        $fileName = "relatorio_area_{$tipo}_" . date('Ymd_His') . ".csv";

        return new StreamedResponse(function () use ($tipo, $busca, $dataInicio, $dataFim) {
            $handle = fopen('php://output', 'w');
            
            // Injeta UTF-8 BOM para compatibilidade com o Microsoft Excel
            fputs($handle, "\xEF\xBB\xBF");

            if ($tipo === 'atendidos') {
                fputcsv($handle, ['Prontuário', 'CPF', 'Paciente', 'Cartão SUS', 'Data Atendimento', 'Município', 'Unidade CNES', 'Tipo Exame', 'Turno', 'Status Comparecimento'], ';');
                
                $dados = $this->getQueryAtendidos($busca, $dataInicio, $dataFim)->get();
                foreach ($dados as $row) {
                    fputcsv($handle, [
                        '#' . ($row->numero_sequencial ?? $row->id_prontuario),
                        $row->cpf_paciente,
                        $row->nome_paciente,
                        $row->cartao_sus ?? 'Não informado',
                        $row->data_atendimento,
                        $row->municipio_atendimento ?? 'Municipal',
                        $row->nome_unidade ?? 'Unidade Geral',
                        $row->tipo_exame,
                        $row->turno ?? 'Integral',
                        strtoupper($row->status_comparecimento)
                    ], ';');
                }
            } elseif ($tipo === 'desistencias') {
                fputcsv($handle, ['Prontuário', 'CPF', 'Paciente', 'Telefone', 'Data Agendada', 'Data Cancelamento', 'Tipo Exame', 'Motivo / Status'], ';');
                
                $dados = $this->getQueryDesistencias($busca, $dataInicio, $dataFim)->get();
                foreach ($dados as $row) {
                    $motivo = $row->motivo_rejeicao_documento ?: strtoupper(str_replace('_', ' ', $row->status_comparecimento));
                    fputcsv($handle, [
                        '#' . ($row->numero_sequencial ?? $row->id_prontuario),
                        $row->cpf_paciente,
                        $row->nome_paciente,
                        $row->telefone ?? 'Sem telefone',
                        $row->data_atendimento,
                        $row->data_cancelamento ?? $row->data_atendimento,
                        $row->tipo_exame,
                        $motivo
                    ], ';');
                }
            } elseif ($tipo === 'fila_espera') {
                fputcsv($handle, ['Posição', 'Prontuário', 'CPF', 'Paciente', 'Cartão SUS', 'Telefone', 'Data Entrada', 'Tipo Exame', 'Status Documentos'], ';');
                
                $pos = 1;
                $dados = $this->getQueryFilaEspera($busca)->get();
                foreach ($dados as $row) {
                    fputcsv($handle, [
                        $pos++,
                        '#' . ($row->numero_sequencial ?? $row->id_prontuario),
                        $row->cpf_paciente,
                        $row->nome_paciente,
                        $row->cartao_sus ?? 'Não informado',
                        $row->telefone ?? 'Sem telefone',
                        $row->data_entrada,
                        $row->tipo_exame,
                        strtoupper($row->status_documentos ?? 'pendente')
                    ], ';');
                }
            } elseif ($tipo === 'anamneses') {
                fputcsv($handle, ['ID Anamnese', 'Prontuário', 'CPF', 'Paciente', 'Data Realização', 'Protocolo', 'Médico', 'CRM', 'Resumo Clínico'], ';');
                
                $dados = $this->getQueryAnamneses($busca, $dataInicio, $dataFim)->get();
                foreach ($dados as $row) {
                    $resumo = $row->tipo_anamnese === 'sismama'
                        ? "Nódulo Dir: " . ($row->nodulo_mama_direita ? 'Sim' : 'Não') . " | Risco Câncer: " . ($row->risco_elevado_cancer ? 'Sim' : 'Não') . " | Mamografia Ant: " . ($row->fez_mamografia_anterior ? 'Sim' : 'Não')
                        : "Motivo: {$row->motivo_exame} | Preventivo Ant: " . ($row->fez_preventivo_anterior ? 'Sim' : 'Não') . " | Pílula: " . ($row->usa_pilula ? 'Sim' : 'Não');

                    fputcsv($handle, [
                        $row->id_fato_anamnese,
                        '#' . ($row->numero_sequencial ?? $row->id_prontuario),
                        $row->cpf_paciente,
                        $row->nome_paciente,
                        $row->data_realizacao,
                        strtoupper($row->tipo_anamnese),
                        $row->nome_profissional,
                        $row->crm,
                        $resumo
                    ], ';');
                }
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ]);
    }
}