<?php

/**
 * =========================================================================
 * CONTROLLER DE GESTÃO DE AGENDAMENTOS (MATEUS)
 * Arquivo: app/Http/Controllers/ListaAgendamentoController.php
 * =========================================================================
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListaAgendamentoController extends Controller
{
    /**
     * Tela de Gestão: Lista de Agendamentos (Para o Operador/Recepção)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $statusDocumentos = $request->input('status_documentos');

        $query = DB::table('fato_prontuario')
            ->join('dim_pacientes', 'fato_prontuario.cpf_paciente', '=', 'dim_pacientes.cpf_paciente')
            ->join('fato_cronogramas', 'fato_prontuario.id_agenda', '=', 'fato_cronogramas.id_agenda')
            ->select(
                'fato_prontuario.id_prontuario as id',
                'fato_prontuario.id_prontuario as numero_agendamento',
                'dim_pacientes.cpf_paciente',
                'dim_pacientes.nome_completo as nome_paciente',
                'fato_cronogramas.data_atendimento as horario_agendamento',
                'fato_prontuario.status_comparecimento as status',
                'fato_prontuario.status_documento as status_documentos',
                DB::raw("CASE WHEN fato_prontuario.status_comparecimento = 'confirmado' THEN 1 ELSE 0 END as cliente_confirmou")
            );

        // Filtro por texto (Nome, CPF, Número)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('dim_pacientes.nome_completo', 'like', "%{$search}%")
                  ->orWhere('dim_pacientes.cpf_paciente', 'like', "%{$search}%")
                  ->orWhere('fato_prontuario.id_prontuario', 'like', "%{$search}%");
            });
        }

        // Filtro por status do agendamento
        if (!empty($status)) {
            $query->where('fato_prontuario.status_comparecimento', $status);
        }

        // Filtro por status da validação dos documentos
        if (!empty($statusDocumentos)) {
            $query->where('fato_prontuario.status_documento', $statusDocumentos);
        }

        $showAgendamentos = $query->orderBy('fato_cronogramas.data_atendimento', 'desc')->paginate(10);

        return view('listaagendamentos.index', compact('showAgendamentos'));
    }

    /**
     * Retorna dados para o Modal via AJAX
     */
    public function show($id)
    {
        $agendamento = DB::table('fato_prontuario')
            ->join('dim_pacientes', 'fato_prontuario.cpf_paciente', '=', 'dim_pacientes.cpf_paciente')
            ->join('fato_cronogramas', 'fato_prontuario.id_agenda', '=', 'fato_cronogramas.id_agenda')
            ->join('dim_vagas', 'fato_cronogramas.Vagas_id_vagas', '=', 'dim_vagas.id_vagas')
            ->where('fato_prontuario.id_prontuario', $id)
            ->first();

        return response()->json(['agendamento' => $agendamento]);
    }

    /**
     * 1ª ETAPA: Validação dos Documentos pelo Operador
     */
    public function validarDocumentos(Request $request, $id)
    {
        $decisao = $request->input('status_documentos'); // 'aprovado', 'validar_no_ato', 'rejeitado'

        $prontuario = DB::table('fato_prontuario')
            ->where('id_prontuario', $id)
            ->first();

        if (!$prontuario) {
            return response()->json(['error' => 'Agendamento não encontrado.'], 404);
        }

        $novoStatus = ($decisao === 'rejeitado') ? 'cancelado' : 'confirmado';
        $statusDoc = ($decisao === 'rejeitado') ? 'rejeitado' : 'aprovado';

        DB::table('fato_prontuario')
            ->where('id_prontuario', $prontuario->id_prontuario)
            ->update([
                'status_documento' => $statusDoc,
                'status_comparecimento' => $novoStatus,
                'updated_at' => Carbon::now()
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * 2ª ETAPA: Confirmação de Presença pelo Paciente
     */
    public function confirmarHorarioPeloPaciente(Request $request, $id)
    {
        $aceitouHorario = $request->boolean('aceitou_horario', true);

        $prontuario = DB::table('fato_prontuario')
            ->where('id_prontuario', $id)
            ->first();

        if (!$prontuario) {
            return redirect()->back()->with('error', 'Agendamento não encontrado.');
        }

        if ($aceitouHorario) {
            DB::table('fato_prontuario')
                ->where('id_prontuario', $prontuario->id_prontuario)
                ->update([
                    'status_comparecimento' => 'confirmado',
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->back()->with('success', 'Presença confirmada com sucesso!');
        } else {
            DB::table('fato_prontuario')
                ->where('id_prontuario', $prontuario->id_prontuario)
                ->update([
                    'status_comparecimento' => 'cancelado',
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->back()->with('info', 'Agendamento cancelado com sucesso.');
        }
    }

    /**
     * Cancelamento acionado pelo botão cancelar do paciente
     */
    public function cancelarPeloPaciente($id)
    {
        $prontuario = DB::table('fato_prontuario')
            ->where('id_prontuario', $id)
            ->first();

        if ($prontuario) {
            DB::table('fato_prontuario')
                ->where('id_prontuario', $prontuario->id_prontuario)
                ->update([
                    'status_comparecimento' => 'cancelado',
                    'updated_at' => Carbon::now()
                ]);
        }

        return redirect()->back()->with('success', 'Agendamento cancelado com sucesso.');
    }
}