<?php

namespace App\Http\Controllers;

use App\Models\Prontuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListaProntuarioController extends Controller
{
    /**
     * Exibe a listagem de prontuários / agendamentos para Triagem Administrativa (N1).
     * Permite busca por paciente/CPF e filtros por status de comparecimento e documento.
     */
    public function index(Request $request)
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

        return view('listaProntuario.listaProntuario', [
            'lista_agendamentos' => $lista_agendamentos,
            'termo_busca' => $termo_busca,
            'filtro_status' => $filtro_status,
            'filtro_documento' => $filtro_documento,
            'total_pendentes' => $total_pendentes,
            'total_aprovados' => $total_aprovados,
            'total_rejeitados' => $total_rejeitados,
        ]);
    }

    /**
     * Atualiza o status de comparecimento do prontuário / agendamento (ex: confirmado, presente, faltou, cancelado).
     */
    public function atualizar_status(Request $request, $id_prontuario)
    {
        $dados_validados = $request->validate([
            'status_comparecimento' => 'required|in:agendado,confirmado,espera,presente,faltou,cancelado',
        ], [
            'status_comparecimento.required' => 'Selecione um status válido.',
            'status_comparecimento.in' => 'O status informado não é reconhecido.',
        ]);

        $prontuario = Prontuario::findOrFail($id_prontuario);
        $prontuario->update([
            'status_comparecimento' => $dados_validados['status_comparecimento'],
        ]);

        return redirect()->back()->with('sucesso', "Status do prontuário #{$id_prontuario} atualizado para '{$dados_validados['status_comparecimento']}'.");
    }

    /**
     * Avaliação de documento na Triagem N1 (Aprovação ou Rejeição com Motivo).
     */
    public function avaliar_documento(Request $request, $id_prontuario)
    {
        $dados_validados = $request->validate([
            'status_documento' => 'required|in:aprovado,rejeitado',
            'motivo_rejeicao_documento' => 'nullable|required_if:status_documento,rejeitado|string|max:255',
        ], [
            'status_documento.required' => 'Informe se o documento foi aprovado ou rejeitado.',
            'motivo_rejeicao_documento.required_if' => 'Ao rejeitar um documento, descreva o motivo para orientar a reanexação.',
        ]);

        $prontuario = Prontuario::findOrFail($id_prontuario);

        $atualizacoes = [
            'status_documento' => $dados_validados['status_documento'],
            'motivo_rejeicao_documento' => $dados_validados['status_documento'] === 'rejeitado'
                ? $dados_validados['motivo_rejeicao_documento']
                : null,
        ];

        // Se o documento for aprovado e ainda estava apenas 'agendado', confirma presença
        if ($dados_validados['status_documento'] === 'aprovado' && $prontuario->status_comparecimento === 'agendado') {
            $atualizacoes['status_comparecimento'] = 'confirmado';
        }

        $prontuario->update($atualizacoes);

        $mensagem = $dados_validados['status_documento'] === 'aprovado'
            ? "Documento do prontuário #{$id_prontuario} aprovado com sucesso!"
            : "Documento do prontuário #{$id_prontuario} foi rejeitado. O paciente poderá reanexar um novo arquivo.";

        return redirect()->back()->with('sucesso', $mensagem);
    }

    /**
     * Permite a reanexação de um novo documento substituindo o arquivo rejeitado.
     */
    public function reanexar_documento(Request $request, $id_prontuario)
    {
        $dados_validados = $request->validate([
            'novo_documento_rg_cpf' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'novo_documento_requisicao' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ], [
            'novo_documento_rg_cpf.mimes' => 'O RG/CPF deve estar no formato JPG, PNG ou PDF.',
            'novo_documento_rg_cpf.max' => 'O RG/CPF não pode ultrapassar 5MB.',
            'novo_documento_requisicao.mimes' => 'A requisição médica deve estar no formato JPG, PNG ou PDF.',
            'novo_documento_requisicao.max' => 'A requisição médica não pode ultrapassar 5MB.',
        ]);

        $prontuario = Prontuario::findOrFail($id_prontuario);

        // Se um novo RG/CPF foi enviado
        if ($request->hasFile('novo_documento_rg_cpf')) {
            // Remove o arquivo anterior do storage se existir
            if ($prontuario->caminho_documento_rg_cpf && Storage::disk('public')->exists($prontuario->caminho_documento_rg_cpf)) {
                Storage::disk('public')->delete($prontuario->caminho_documento_rg_cpf);
            }

            $prontuario->caminho_documento_rg_cpf = $request->file('novo_documento_rg_cpf')->store('documentos_agendamentos', 'public');
        }

        // Se uma nova requisição foi enviada
        if ($request->hasFile('novo_documento_requisicao')) {
            if ($prontuario->caminho_documento_requisicao && Storage::disk('public')->exists($prontuario->caminho_documento_requisicao)) {
                Storage::disk('public')->delete($prontuario->caminho_documento_requisicao);
            }

            $prontuario->caminho_documento_requisicao = $request->file('novo_documento_requisicao')->store('documentos_agendamentos', 'public');
        }

        // Reseta o status do documento para pendente de nova análise
        $prontuario->status_documento = 'pendente';
        $prontuario->motivo_rejeicao_documento = null;
        $prontuario->save();

        return redirect()->back()->with('sucesso', "Novo documento reanexado com sucesso para o prontuário #{$id_prontuario}!");
    }
}
