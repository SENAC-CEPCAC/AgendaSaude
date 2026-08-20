<?php

namespace App\Http\Controllers;

use App\Models\CnesUnidade;
use App\Models\Cronograma;
use App\Models\Paciente;
use App\Models\Prontuario;
use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AgendamentoEtapa3Controller extends Controller
{
    /**
     * Exibe a Etapa 3 do agendamento (Upload de Documentos e Revisão).
     */
    public function index(Request $request)
    {
        $dados_etapa_1 = session('agendamento.etapa_1', []);
        $dados_etapa_2 = session('agendamento.etapa_2', []);

        $unidade_selecionada = !empty($dados_etapa_1['id_cnes_unidade'])
            ? CnesUnidade::find($dados_etapa_1['id_cnes_unidade'])
            : null;

        $tipo_exame_selecionado = !empty($dados_etapa_1['id_vagas'])
            ? Vaga::find($dados_etapa_1['id_vagas'])
            : null;

        $cronograma_selecionado = !empty($dados_etapa_2['id_agenda'])
            ? Cronograma::with(['unidade', 'turno', 'vaga'])->find($dados_etapa_2['id_agenda'])
            : null;

        return view('fluxo_agendamento.etapa_3', [
            'dados_etapa_1' => $dados_etapa_1,
            'dados_etapa_2' => $dados_etapa_2,
            'unidade_selecionada' => $unidade_selecionada,
            'tipo_exame_selecionado' => $tipo_exame_selecionado,
            'cronograma_selecionado' => $cronograma_selecionado,
        ]);
    }

    /**
     * Valida os uploads (máx 5MB e formatos), armazena os documentos no storage
     * e cria o registro de agendamento na tabela fato_prontuario.
     */
    public function store(Request $request)
    {
        // 1. Validação estrita dos arquivos e dados
        $dados_validados = $request->validate([
            'documento_rg_cpf' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'documento_requisicao' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'cpf_paciente' => 'nullable|string|max:14',
        ], [
            'documento_rg_cpf.required' => 'O envio da foto ou PDF do documento de identificação (RG/CPF) é obrigatório.',
            'documento_rg_cpf.file' => 'O documento de identificação anexado é inválido.',
            'documento_rg_cpf.mimes' => 'O documento de identificação deve estar no formato JPG, PNG ou PDF.',
            'documento_rg_cpf.max' => 'O documento de identificação não pode ultrapassar o tamanho máximo de 5MB.',
            'documento_requisicao.mimes' => 'A requisição médica deve estar no formato JPG, PNG ou PDF.',
            'documento_requisicao.max' => 'A requisição médica não pode ultrapassar o tamanho máximo de 5MB.',
        ]);

        $dados_etapa_1 = session('agendamento.etapa_1', []);
        $dados_etapa_2 = session('agendamento.etapa_2', []);

        // 2. Identificação do paciente (autenticado ou primeiro paciente de demonstração)
        $cpf_paciente = Paciente::first()?->cpf_paciente ?? '12345678901';
        if (!empty($dados_validados['cpf_paciente'])) {
            $cpf_limpo = preg_replace('/[^0-9]/', '', $dados_validados['cpf_paciente']);
            $paciente_encontrado = Paciente::find($cpf_limpo);
            if ($paciente_encontrado) {
                $cpf_paciente = $paciente_encontrado->cpf_paciente;
            }
        } elseif (auth()->check()) {
            $cpf_paciente = auth()->user()->identificacao ?? auth()->id();
        }

        // 3. Identificação do cronograma
        $id_agenda = !empty($dados_etapa_2['id_agenda']) ? $dados_etapa_2['id_agenda'] : 1;
        $cronograma = Cronograma::find($id_agenda);

        // 4. Determina status inicial de comparecimento: 'agendado' ou 'espera' (se lotado)
        $status_comparecimento = 'agendado';
        if ($cronograma && $cronograma->prenchida_vagas >= $cronograma->qnt_oferecidas_vagas) {
            $status_comparecimento = 'espera';
        }

        // 5. Upload seguro dos arquivos no disco público
        $caminho_documento_rg_cpf = null;
        if ($request->hasFile('documento_rg_cpf')) {
            $caminho_documento_rg_cpf = $request->file('documento_rg_cpf')->store('documentos_agendamentos', 'public');
        }

        $caminho_documento_requisicao = null;
        if ($request->hasFile('documento_requisicao')) {
            $caminho_documento_requisicao = $request->file('documento_requisicao')->store('documentos_agendamentos', 'public');
        }

        // 6. Transação de criação do prontuário e incremento de vagas
        DB::transaction(function () use (
            $cpf_paciente,
            $id_agenda,
            $status_comparecimento,
            $caminho_documento_rg_cpf,
            $caminho_documento_requisicao,
            $cronograma
        ) {
            Prontuario::create([
                'cpf_paciente' => $cpf_paciente,
                'id_agenda' => $id_agenda,
                'status_comparecimento' => $status_comparecimento,
                'caminho_documento_rg_cpf' => $caminho_documento_rg_cpf,
                'caminho_documento_requisicao' => $caminho_documento_requisicao,
                'status_documento' => 'pendente',
                'motivo_rejeicao_documento' => null,
            ]);

            // Se confirmou vaga titular, incrementa o total preenchido
            if ($status_comparecimento === 'agendado' && $cronograma) {
                $cronograma->increment('prenchida_vagas');
            }
        });

        // 7. Limpeza dos dados temporários da sessão
        session()->forget(['agendamento.etapa_1', 'agendamento.etapa_2']);

        return redirect()->route('agendamento.confirmado')->with(
            'sucesso',
            $status_comparecimento === 'agendado'
                ? 'Agendamento e envio de documentos realizados com sucesso!'
                : 'Você foi inserido(a) na lista de espera inteligente com sucesso!'
        );
    }
}
