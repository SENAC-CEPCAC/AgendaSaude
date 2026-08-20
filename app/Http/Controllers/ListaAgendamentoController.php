<?php

/**
 * =========================================================================
 * 3. CONTROLLER PRINCIPAL
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
            ->join('dim_pacientes', 'fato_prontuario.id_paciente', '=', 'dim_pacientes.id_paciente')
            ->join('fato_cronogramas', 'fato_prontuario.id_agenda', '=', 'fato_cronogramas.id_agenda')
            ->select(
                'fato_prontuario.id_prontuario as id',
                'fato_prontuario.numero_sequencial as numero_agendamento',
                'dim_pacientes.cpf as cpf_paciente',
                DB::raw("CONCAT(dim_pacientes.nome_completo) as nome_paciente"),
                'fato_cronogramas.data_atendimento as horario_agendamento',
                'fato_prontuario.status_agendamento as status',
                'fato_prontuario.status_documentos',
                'fato_prontuario.cliente_confirmou'
            );

        // Filtro por texto (Nome, CPF, Número)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('dim_pacientes.nome_completo', 'like', "%{$search}%")
                  ->orWhere('dim_pacientes.cpf', 'like', "%{$search}%")
                  ->orWhere('fato_prontuario.numero_sequencial', 'like', "%{$search}%");
            });
        }

        // Filtro por status do agendamento
        if (!empty($status)) {
            $query->where('fato_prontuario.status_agendamento', $status);
        }

        // Filtro por status da validação dos documentos
        if (!empty($statusDocumentos)) {
            $query->where('fato_prontuario.status_documentos', $statusDocumentos);
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
            ->join('dim_pacientes', 'fato_prontuario.id_paciente', '=', 'dim_pacientes.id_paciente')
            ->join('fato_cronogramas', 'fato_prontuario.id_agenda', '=', 'fato_cronogramas.id_agenda')
            ->join('dim_vagas', 'fato_cronogramas.Vagas_id_vagas', '=', 'dim_vagas.id_vagas')
            ->where('fato_prontuario.numero_sequencial', $id)
            ->orWhere('fato_prontuario.id_prontuario', $id)
            ->first();

        return response()->json(['agendamento' => $agendamento]);
    }

    /**
     * 1ª ETAPA: Validação dos Documentos pelo Operador
     */
    public function validarDocumentos(Request $request, $id)
    {
        $decisao = $request->input('status_documentos'); // 'aprovado', 'validar_no_ato', 'rejeitado'
        $operadorId = auth()->id() ?? 1;

        $prontuario = DB::table('fato_prontuario')
            ->where('id_prontuario', $id)
            ->orWhere('numero_sequencial', $id)
            ->first();

        if (!$prontuario) {
            return response()->json(['error' => 'Agendamento não encontrado.'], 404);
        }

        $novoStatus = ($decisao === 'rejeitado') ? 'cancelado' : 'aguardando_confirmacao';

        DB::table('fato_prontuario')
            ->where('id_prontuario', $prontuario->id_prontuario)
            ->update([
                'status_documentos' => $decisao,
                'status_agendamento' => $novoStatus,
                'operador_validou_id' => $operadorId,
                'data_validacao_operador' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        // Se o operador rejeitou, libera a vaga e oferta para o próximo da fila inteligente
        if ($decisao === 'rejeitado') {
            $this->notificarProximoDaFilaParaAceiteHorario($prontuario);
        }

        return response()->json(['success' => true]);
    }

    /**
     * 2ª ETAPA: Confirmação de Presença pelo Paciente (Botão no agendamentos.blade.php)
     */
    public function confirmarHorarioPeloPaciente(Request $request, $id)
    {
        $aceitouHorario = $request->boolean('aceitou_horario', true);
        $motivoRecusa   = $request->input('motivo_recusa');

        $prontuario = DB::table('fato_prontuario')
            ->where('id_prontuario', $id)
            ->orWhere('numero_sequencial', $id)
            ->first();

        if (!$prontuario) {
            return redirect()->back()->with('error', 'Agendamento não encontrado.');
        }

        if ($aceitouHorario) {
            // Paciente confirmou presença
            DB::table('fato_prontuario')
                ->where('id_prontuario', $prontuario->id_prontuario)
                ->update([
                    'cliente_confirmou' => true,
                    'data_confirmacao_cliente' => Carbon::now(),
                    'status_agendamento' => 'confirmado',
                    'updated_at' => Carbon::now()
                ]);

            return redirect()->back()->with('success', 'Presença confirmada com sucesso!');
        } else {
            // Paciente recusou -> Vaga é ofertada para o próximo da fila
            DB::table('fato_prontuario')
                ->where('id_prontuario', $prontuario->id_prontuario)
                ->update([
                    'cliente_confirmou' => false,
                    'data_confirmacao_cliente' => Carbon::now(),
                    'status_agendamento' => 'cancelado',
                    'updated_at' => Carbon::now()
                ]);

            $this->notificarProximoDaFilaParaAceiteHorario($prontuario);

            return redirect()->back()->with('info', 'Agendamento cancelado. A vaga foi repassada para a fila de espera.');
        }
    }

    /**
     * Cancelamento acionado pelo botão cancelar do paciente
     */
    public function cancelarPeloPaciente($id)
    {
        $prontuario = DB::table('fato_prontuario')
            ->where('id_prontuario', $id)
            ->orWhere('numero_sequencial', $id)
            ->first();

        if ($prontuario) {
            DB::table('fato_prontuario')
                ->where('id_prontuario', $prontuario->id_prontuario)
                ->update([
                    'status_agendamento' => 'cancelado',
                    'updated_at' => Carbon::now()
                ]);

            // Aloca e oferta a vaga ao próximo da fila de espera
            $this->notificarProximoDaFilaParaAceiteHorario($prontuario);
        }

        return redirect()->back()->with('success', 'Agendamento cancelado com sucesso.');
    }

    /**
     * MOTOR AUTOMÁTICO: Localiza o próximo da fila de espera (FIFO)
     */
    protected function notificarProximoDaFilaParaAceiteHorario($prontuarioDesistente)
    {
        $proximoPaciente = DB::table('fato_prontuario')
            ->where('status_agendamento', 'em_espera')
            ->orderBy('numero_sequencial', 'asc')
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$proximoPaciente) {
            return null;
        }

        $cronograma = DB::table('fato_cronogramas')->where('id_agenda', $prontuarioDesistente->id_agenda)->first();
        $limiteConfirmacao = $cronograma ? Carbon::parse($cronograma->data_atendimento)->subHours(24) : Carbon::now()->addHours(12);

        DB::table('fato_prontuario')
            ->where('id_prontuario', $proximoPaciente->id_prontuario)
            ->update([
                'id_agenda' => $prontuarioDesistente->id_agenda,
                'status_agendamento' => 'aguardando_confirmacao',
                'limite_confirmacao_24h' => $limiteConfirmacao,
                'promovido_da_fila' => true,
                'substituiu_prontuario_id' => $prontuarioDesistente->id_prontuario,
                'motivo_promocao' => "Oferta de vaga após desistência do agendamento #{$prontuarioDesistente->numero_sequencial}",
                'updated_at' => Carbon::now()
            ]);

        return $proximoPaciente;
    }
}