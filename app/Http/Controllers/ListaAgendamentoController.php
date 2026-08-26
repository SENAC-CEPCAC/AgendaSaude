<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\UserColaborador;

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

        // Identifica o usuário autenticado
        $paciente = Auth::user();
        $colaboradorId = session('colaborador_id');

        if ($paciente) {

            // Paciente
            $nivel = 1;
            $cpfPaciente = $paciente->cpf_paciente;
        } elseif ($colaboradorId) {

            // Colaborador
            $colaborador = UserColaborador::find($colaboradorId);

            if (!$colaborador || !$colaborador->ativo) {
                abort(401, 'Colaborador não autenticado.');
            }

            $nivel = (int) $colaborador->permissao;
            $cpfPaciente = null;
        } else {

            abort(401, 'Usuário não autenticado.');
        }


        $temColunaHorario = \Illuminate\Support\Facades\Schema::hasColumn('fato_prontuario', 'horario_agendamento');
        $selectHorario = $temColunaHorario
            ? DB::raw("COALESCE(fato_prontuario.horario_agendamento, dim_turno.turno, '08:00') as horario_agendamento")
            : DB::raw("COALESCE(dim_turno.turno, '08:00') as horario_agendamento");
        $selectHoraEspecifica = $temColunaHorario
            ? DB::raw("fato_prontuario.horario_agendamento as hora_especifica")
            : DB::raw("dim_turno.turno as hora_especifica");

        $query = DB::table('fato_prontuario')
            ->join(
                'dim_pacientes',
                'fato_prontuario.cpf_paciente',
                '=',
                'dim_pacientes.cpf_paciente'
            )
            ->join(
                'fato_cronogramas',
                'fato_prontuario.id_agenda',
                '=',
                'fato_cronogramas.id_agenda'
            )
            ->leftJoin(
                'dim_vagas',
                'fato_cronogramas.Vagas_id_vagas',
                '=',
                'dim_vagas.id_vagas'
            )
            ->leftJoin(
                'dim_cnes_unidades',
                'fato_cronogramas.id_cnes_unidade',
                '=',
                'dim_cnes_unidades.id_cnes_unidade'
            )
            ->leftJoin(
                'dim_turno',
                'fato_cronogramas.Turno_id_turno',
                '=',
                'dim_turno.id_turno'
            )
            ->select(
                'fato_prontuario.id_prontuario as id',
                'fato_prontuario.id_prontuario as numero_agendamento',
                'fato_prontuario.numero_sequencial',
                'dim_pacientes.cpf_paciente',
                'dim_pacientes.nome_completo as nome_paciente',
                'dim_pacientes.cartao_sus',
                'fato_cronogramas.data_atendimento',
                $selectHoraEspecifica,
                'fato_cronogramas.municipio_atendimento',
                'dim_vagas.tipo_exame as especialidade',
                'dim_cnes_unidades.nome_unidade',
                'dim_turno.turno',
                'fato_prontuario.status_comparecimento',
                'fato_prontuario.status_comparecimento as status',
                'fato_prontuario.status_documento as status_documentos',
                'fato_prontuario.status_agendamento',
                'fato_prontuario.caminho_documento_rg_cpf as documento_rg_cpf',
                'fato_prontuario.caminho_documento_requisicao as documento_requisicao',
                'fato_prontuario.caminho_documento_rg_cpf as url_documento_rg_cpf',
                'fato_prontuario.caminho_documento_requisicao as url_documento_requisicao',
                $selectHorario,
                DB::raw("
                CASE 
                    WHEN fato_prontuario.status_comparecimento = 'confirmado'
                    THEN 1
                    ELSE 0
                END as cliente_confirmou
            ")
            );

        /*
         * PACIENTE - somente seus próprios agendamentos
         */
        if ($nivel === 1 && !empty($cpfPaciente)) {
            $query->where(
                'fato_prontuario.cpf_paciente',
                $cpfPaciente
            );
        }

        /*
     * FILTRO DE PESQUISA
     */
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where(
                    'dim_pacientes.nome_completo',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'dim_pacientes.cpf_paciente',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'fato_prontuario.id_prontuario',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        /*
     * FILTRO DE STATUS
     */
        if (!empty($status)) {
            $query->where(function ($q) use ($status) {
                $q->where(
                    'fato_prontuario.status_comparecimento',
                    $status
                )
                    ->orWhere(
                        'fato_prontuario.status_agendamento',
                        $status
                    );
            });
        }

        /*
     * FILTRO DE DOCUMENTOS
     */
        if (!empty($statusDocumentos)) {
            $query->where(
                'fato_prontuario.status_documento',
                $statusDocumentos
            );
        }

        $showAgendamentos = $query
            ->orderBy('fato_cronogramas.data_atendimento', 'desc')
            ->paginate(10);

        return view(
            'listaagendamentos.index',
            compact('showAgendamentos')
        );
    }

    /**
     * Retorna dados completos para o Modal via AJAX, incluindo URLs públicas dos documentos
     */
    public function show($id)
    {
        $temColunaHorario = \Illuminate\Support\Facades\Schema::hasColumn('fato_prontuario', 'horario_agendamento');
        $selectHorario = $temColunaHorario
            ? DB::raw("COALESCE(fato_prontuario.horario_agendamento, dim_turno.turno, '08:00') as horario_agendamento")
            : DB::raw("COALESCE(dim_turno.turno, '08:00') as horario_agendamento");

        $agendamento = DB::table('fato_prontuario')
            ->join('dim_pacientes', 'fato_prontuario.cpf_paciente', '=', 'dim_pacientes.cpf_paciente')
            ->join('fato_cronogramas', 'fato_prontuario.id_agenda', '=', 'fato_cronogramas.id_agenda')
            ->leftJoin('dim_vagas', 'fato_cronogramas.Vagas_id_vagas', '=', 'dim_vagas.id_vagas')
            ->leftJoin('dim_turno', 'fato_cronogramas.Turno_id_turno', '=', 'dim_turno.id_turno')
            ->where('fato_prontuario.id_prontuario', $id)
            ->orWhere('fato_prontuario.numero_sequencial', $id)
            ->select(
                'fato_prontuario.id_prontuario',
                'fato_prontuario.numero_sequencial',
                'dim_pacientes.cpf_paciente',
                'dim_pacientes.nome_completo as nome_paciente',
                'dim_pacientes.cartao_sus',
                'fato_cronogramas.data_atendimento',
                $selectHorario,
                'dim_vagas.tipo_exame as nome_vaga',
                'fato_prontuario.status_documento as status_documentos',
                'fato_prontuario.status_comparecimento',
                'fato_prontuario.caminho_documento_rg_cpf',
                'fato_prontuario.caminho_documento_requisicao'
            )
            ->first();

        if ($agendamento) {
            // Gera as URLs acessíveis publicamente para exibição no modal
            $agendamento->url_documento_rg_cpf = !empty($agendamento->caminho_documento_rg_cpf)
                ? Storage::disk('public')->url($agendamento->caminho_documento_rg_cpf)
                : null;

            $agendamento->url_documento_requisicao = !empty($agendamento->caminho_documento_requisicao)
                ? Storage::disk('public')->url($agendamento->caminho_documento_requisicao)
                : null;
        }

        return response()->json(['agendamento' => $agendamento]);
    }

    /**
     * Atualização do Status de Comparecimento (Presente, Atrasado, Não Compareceu)
     */
    public function atualizarStatusComparecimento(Request $request, $id)
    {
        $request->validate([
            'status_comparecimento' => 'required|in:presente,atrasado,nao_compareceu,faltou,confirmado,agendado,cancelado'
        ]);

        $status = $request->input('status_comparecimento');

        DB::table('fato_prontuario')
            ->where('id_prontuario', $id)
            ->orWhere('numero_sequencial', $id)
            ->update([
                'status_comparecimento' => $status,
                'updated_at' => Carbon::now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Status de comparecimento atualizado com sucesso!'
        ]);
    }

    /**
     * 1ª ETAPA: Validação dos Documentos pelo Operador
     */
    public function validarDocumentos(Request $request, $id)
    {
        $decisao = $request->input('status_documentos'); // 'aprovado', 'validar_no_ato', 'rejeitado'

        $prontuario = DB::table('fato_prontuario')
            ->where('id_prontuario', $id)
            ->orWhere('numero_sequencial', $id)
            ->first();

        if (!$prontuario) {
            return response()->json(['error' => 'Agendamento não encontrado.'], 404);
        }

        $novoStatusComparecimento = ($decisao === 'rejeitado') ? 'cancelado' : 'confirmado';
        $statusDoc = ($decisao === 'rejeitado') ? 'rejeitado' : ($decisao === 'validar_no_ato' ? 'validar_no_ato' : 'aprovado');

        DB::table('fato_prontuario')
            ->where('id_prontuario', $prontuario->id_prontuario)
            ->update([
                'status_documento' => $statusDoc,
                'status_comparecimento' => $novoStatusComparecimento,
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
            ->orWhere('numero_sequencial', $id)
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
            ->orWhere('numero_sequencial', $id)
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

    public function verDocumento($id, $tipo)
    {
        $agendamento = DB::table('fato_prontuario')
            ->where('id_prontuario', $id)
            ->orWhere('numero_sequencial', $id)
            ->first();

        if (!$agendamento) {
            abort(404, 'Agendamento não encontrado.');
        }

        $coluna = ($tipo === 'rg' || $tipo === 'rg_cpf') ? 'caminho_documento_rg_cpf' : 'caminho_documento_requisicao';
        $caminhoBanco = $agendamento->$coluna ?? null;

        if (!$caminhoBanco) {
            abort(404, 'Documento não informado.');
        }

        // Extrai apenas o nome do arquivo caso venha com caminho completo
        $nomeArquivo = basename($caminhoBanco);

        // Lista de locais onde o arquivo pode estar localizado
        $candidatos = [
            storage_path('app/public/documentos_agendamentos/' . $nomeArquivo),
            storage_path('app/public/documentos_agendamentos/' . $caminhoBanco),
        ];

        foreach ($candidatos as $path) {
            if (file_exists($path)) {
                return response()->file($path, [
                    'Cache-Control' => 'no-cache, private',
                ]);
            }
        }

        abort(404, 'Arquivo não encontrado no servidor: ' . $nomeArquivo);
    }
}
