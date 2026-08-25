<?php

namespace App\Http\Controllers;

use App\Models\FatoAnamnese;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
}