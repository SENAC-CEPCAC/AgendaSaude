<?php

namespace App\Http\Controllers;

use App\Models\FatoAnamnese;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Paciente;
use App\Models\Prontuario;
use Carbon\Carbon;

class AnamneseDoDiaController extends Controller
{
    /**
     * Lista as anamneses (colo + mama) dentro de um intervalo de datas.
     * Por padrão, mostra só o dia de hoje (data_inicio = data_fim = hoje).
     */
    public function index(Request $request)
    {
        $dataInicio = $request->query('data_inicio', now()->toDateString());
        $dataFim = $request->query('data_fim', $dataInicio);

        $anamneses = FatoAnamnese::with(['prontuario.paciente', 'anamneseColo', 'anamneseMama'])
            ->whereDate('data_realizacao', '>=', $dataInicio)
            ->whereDate('data_realizacao', '<=', $dataFim)
            ->orderBy('data_realizacao')
            ->get();

        return view('anamnese.dia', [
            'anamneses' => $anamneses,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);
    }

    /**
     * Gera um PDF único com todos os exames (colo + mama) do intervalo,
     * pra imprimir ou enviar como relatório.
     */
    public function pdf(Request $request)
    {
        $dataInicio = $request->query('data_inicio', now()->toDateString());
        $dataFim = $request->query('data_fim', $dataInicio);

        $anamneses = FatoAnamnese::with(['prontuario.paciente', 'anamneseColo', 'anamneseMama'])
            ->whereDate('data_realizacao', '>=', $dataInicio)
            ->whereDate('data_realizacao', '<=', $dataFim)
            ->orderBy('data_realizacao')
            ->get();

        $pdf = Pdf::loadView('anamnese.dia-pdf', [
            'anamneses' => $anamneses,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);

        return $pdf->stream('relatorio-exames-' . $dataInicio . '_a_' . $dataFim . '.pdf');
    }

    public function anamnesePaciente(Request $request)
    {
       $termo_busca = $request->input('busca');
        $filtro_status = $request->input('status');
        $filtro_documento = $request->input('status_documento');

        $query_agendamentos = Prontuario::with([
            'paciente.endereco',
            'paciente.telefones',
            'cronograma.unidade',
            'cronograma.vaga',
            'cronograma.turno'
        ]);

        // Filtro de busca textual (Nome do paciente, CPF ou Nº do prontuário)
        if (!empty($termo_busca)) {
            $cpf_limpo = preg_replace('/[^0-9]/', '', $termo_busca);

            $query_agendamentos->where(function ($query) use ($termo_busca, $cpf_limpo) {
                $query->where('id_prontuario', $termo_busca)
                    ->orWhereHas('paciente', function ($q_paciente) use ($termo_busca, $cpf_limpo) {
                        $q_paciente->where('nome_completo', 'like', "%{$termo_busca}%");
                        if (!empty($cpf_limpo)) {
                            $q_paciente->orWhere('cpf_paciente', 'like', "%{$cpf_limpo}%");
                        }
                    });
            });
        }

        // Filtro por status de comparecimento
        if (!empty($filtro_status)) {
            $query_agendamentos->where('status_comparecimento', $filtro_status);
        }

        // Filtro por status do documento
        if (!empty($filtro_documento)) {
            $query_agendamentos->where('status_documento', $filtro_documento);
        }

        $lista_agendamentos = $query_agendamentos->orderBy('id_prontuario', 'desc')->paginate(10);

        // Estatísticas rápidas para o cabeçalho da triagem N1
        $total_pendentes = Prontuario::where('status_documento', 'pendente')->count();
        $total_aprovados = Prontuario::where('status_documento', 'aprovado')->count();
        $total_rejeitados = Prontuario::where('status_documento', 'rejeitado')->count();

        return view('anamnese.index', [
            'lista_agendamentos' => $lista_agendamentos,
            'termo_busca' => $termo_busca,
            'filtro_status' => $filtro_status,
            'filtro_documento' => $filtro_documento,
            'total_pendentes' => $total_pendentes,
            'total_aprovados' => $total_aprovados,
            'total_rejeitados' => $total_rejeitados,
        ]);
    
    }
}