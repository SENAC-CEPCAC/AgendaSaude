<?php

namespace App\Http\Controllers;

use App\Models\Prontuario;
use Illuminate\Http\Request;

class AnamnesePacienteController extends Controller
{
    /**
     * Exibe a listagem de pacientes agendados numa data (padrão: hoje),
     * com acesso rápido para preencher a Anamnese (Colo ou Mama) de cada um.
     */
    public function index(Request $request)
    {
        $termo_busca = $request->input('busca');
        $filtro_status = $request->input('status');

        // Padrão: hoje, igual à tela de "Exames do dia"
        $filtro_data = $request->input('data_atendimento', now()->toDateString());

        $query_agendamentos = Prontuario::with([
            'paciente.endereco',
            'paciente.telefones',
            'cronograma.unidade',
            'cronograma.vaga',
            'cronograma.turno',
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

        // Filtro por data do atendimento (via cronograma), sempre aplicado
        // porque a tela sempre mostra "os pacientes de um dia".
        if (!empty($filtro_data)) {
            $query_agendamentos->whereHas('cronograma', function ($q) use ($filtro_data) {
                $q->whereDate('data_atendimento', $filtro_data);
            });
        }

        $lista_agendamentos = $query_agendamentos->orderBy('id_prontuario', 'desc')->paginate(10)->withQueryString();

        return view('listaProntuario.anamnesePaciente', [
            'lista_agendamentos' => $lista_agendamentos,
            'termo_busca' => $termo_busca,
            'filtro_status' => $filtro_status,
            'filtro_data' => $filtro_data,
        ]);
    }
}