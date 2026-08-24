<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RelatorioController extends Controller
{
    /**
     * 1. RELATÓRIO DE PACIENTES ATENDIDOS
     * Tabelas: fato_prontuario + dim_pacientes + fato_cronogramas + dim_vagas + dim_turno + dim_cnes_unidades
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
                $q->where('p.status_comparecimento', 'presente')
                  ->orWhere('p.status_agendamento', 'confirmado');
            });

        if ($busca) {
            $query->where(function ($q) use ($busca) {
                $q->where('pac.nome_completo', 'like', "%{$busca}%")
                  ->orWhere('pac.cpf_paciente', 'like', "%{$busca}%")
                  ->orWhere('pac.cartao_sus', 'like', "%{$busca}%")
                  ->orWhere('v.tipo_exame', 'like', "%{$busca}%");
            });
        }

        if ($dataInicio && $dataFim) {
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
            'p.status_documentos'
        )->orderBy('c.data_atendimento', 'desc');
    }

    /**
     * 2. RELATÓRIO DE QUESTIONÁRIOS DE ANAMNESE (SISMAMA E SISCOLO)
     * Tabelas: fato_anamnese + fato_prontuario + dim_pacientes + dim_profissionais + anamnese_sismama + anamnese_siscolo
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

        if ($tipoProtocolo && in_array($tipoProtocolo, ['sismama', 'siscolo'])) {
            $query->where('a.tipo_anamnese', $tipoProtocolo);
        }

        if ($busca) {
            $query->where(function ($q) use ($busca) {
                $q->where('pac.nome_completo', 'like', "%{$busca}%")
                  ->orWhere('pac.cpf_paciente', 'like', "%{$busca}%")
                  ->orWhere('prof.nome', 'like', "%{$busca}%");
            });
        }

        if ($dataInicio && $dataFim) {
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
     * 3. RELATÓRIO DE DESISTÊNCIAS E EXPIRAÇÕES 24H
     * Tabelas: fato_prontuario + dim_pacientes + dim_telefones_paciente + fato_cronogramas + dim_vagas
     */
    private function getQueryDesistencias($busca = null, $dataInicio = null, $dataFim = null)
    {
        $query = DB::table('fato_prontuario as p')
            ->join('dim_pacientes as pac', 'p.cpf_paciente', '=', 'pac.cpf_paciente')
            ->leftJoin('dim_telefones_paciente as tel', 'pac.cpf_paciente', '=', 'tel.cpf_paciente')
            ->leftJoin('fato_cronogramas as c', 'p.id_agenda', '=', 'c.id_agenda')
            ->leftJoin('dim_vagas as v', 'c.Vagas_id_vagas', '=', 'v.id_vagas')
            ->where(function ($q) {
                $q->where('p.status_comparecimento', 'cancelado')
                  ->orWhere('p.status_agendamento', 'cancelado_prazo_24h')
                  ->orWhere('p.status_documento', 'rejeitado');
            });

        if ($busca) {
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
            'tel.numero as telefone',
            'c.data_atendimento',
            'p.updated_at as data_cancelamento',
            'v.tipo_exame',
            'p.status_agendamento',
            'p.motivo_rejeicao_documento'
        )->orderBy('p.updated_at', 'desc');
    }

    /**
     * 4. RELATÓRIO DA FILA DE ESPERA CRONOLÓGICA
     * Tabelas: fato_prontuario + dim_pacientes + dim_telefones_paciente + fato_cronogramas + dim_vagas
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

        if ($busca) {
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
            'p.status_documentos',
            'p.status_agendamento'
        )->orderBy('p.numero_sequencial', 'asc');
    }

    /**
     * INDEX PRINCIPAL COM PAGINAÇÃO E TOTAIS
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

        $totais = [
            'atendidos' => $this->getQueryAtendidos()->count(),
            'anamneses' => $this->getQueryAnamneses()->count(),
            'desistencias' => $this->getQueryDesistencias()->count(),
            'fila_espera' => $this->getQueryFilaEspera()->count(),
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
     * EXPORTAÇÃO EM CSV / EXCEL
     */
    public function exportarCsv(string $tipo)
    {
        $fileName = "relatorio_{$tipo}_" . date('Y-m-d_His') . ".csv";

        return new StreamedResponse(function () use ($tipo) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF"); // UTF-8 BOM

            if ($tipo === 'atendidos') {
                fputcsv($handle, ['Prontuário', 'CPF', 'Paciente', 'SUS', 'Data Atendimento', 'Município', 'Unidade CNES', 'Tipo Exame', 'Turno', 'Status'], ';');
                foreach ($this->getQueryAtendidos()->get() as $row) {
                    fputcsv($handle, ['#' . $row->numero_sequencial, $row->cpf_paciente, $row->nome_paciente, $row->cartao_sus, $row->data_atendimento, $row->municipio_atendimento, $row->nome_unidade, $row->tipo_exame, $row->turno, $row->status_comparecimento], ';');
                }
            } elseif ($tipo === 'anamneses') {
                fputcsv($handle, ['ID Anamnese', 'Prontuário', 'CPF', 'Paciente', 'Data Realização', 'Protocolo', 'Médico', 'CRM', 'Resumo'], ';');
                foreach ($this->getQueryAnamneses()->get() as $row) {
                    $resumo = $row->tipo_anamnese === 'sismama'
                        ? "Nódulo Dir: " . ($row->nodulo_mama_direita ? 'Sim' : 'Não') . " | Risco Câncer: " . ($row->risco_elevado_cancer ? 'Sim' : 'Não')
                        : "Motivo: {$row->motivo_exame} | Preventivo Anterior: " . ($row->fez_preventivo_anterior ? 'Sim' : 'Não');

                    fputcsv($handle, [$row->id_fato_anamnese, '#' . $row->numero_sequencial, $row->cpf_paciente, $row->nome_paciente, $row->data_realizacao, strtoupper($row->tipo_anamnese), $row->nome_profissional, $row->crm, $resumo], ';');
                }
            } elseif ($tipo === 'desistencias') {
                fputcsv($handle, ['Prontuário', 'CPF', 'Paciente', 'Telefone', 'Data Agendada', 'Data Cancelamento', 'Tipo Exame', 'Motivo'], ';');
                foreach ($this->getQueryDesistencias()->get() as $row) {
                    fputcsv($handle, ['#' . $row->numero_sequencial, $row->cpf_paciente, $row->nome_paciente, $row->telefone, $row->data_atendimento, $row->data_cancelamento, $row->tipo_exame, $row->motivo_rejeicao_documento ?: 'Cancelamento / Expiração 24h'], ';');
                }
            } elseif ($tipo === 'fila_espera') {
                fputcsv($handle, ['Posição', 'Prontuário', 'CPF', 'Paciente', 'Cartão SUS', 'Telefone', 'Data Entrada', 'Exame', 'Documentos'], ';');
                $pos = 1;
                foreach ($this->getQueryFilaEspera()->get() as $row) {
                    fputcsv($handle, [$pos++, '#' . $row->numero_sequencial, $row->cpf_paciente, $row->nome_paciente, $row->cartao_sus, $row->telefone, $row->data_entrada, $row->tipo_exame, $row->status_documentos], ';');
                }
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }
}