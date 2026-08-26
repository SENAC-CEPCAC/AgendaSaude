<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Prontuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProntuarioVisualizacaoController extends Controller
{
    /**
     * Exibe o prontuário eletrônico completo e detalhado do paciente.
     *
     * @param int|string $id ID do Prontuário ou CPF do Paciente
     */
    public function show($id)
    {
        // 1. Tenta carregar por ID do Prontuário com todas as relações clínicas
        $prontuario = Prontuario::with([
            'paciente.endereco',
            'paciente.telefones',
            'cronograma.unidade',
            'cronograma.vaga',
            'cronograma.turno',
            'anamnese.anamneseColo',
            'anamnese.anamneseMama',
            'feedback',
        ])->find($id);

        // Se não encontrar por ID, tenta buscar pelo CPF do paciente
        if (!$prontuario) {
            $prontuario = Prontuario::with([
                'paciente.endereco',
                'paciente.telefones',
                'cronograma.unidade',
                'cronograma.vaga',
                'cronograma.turno',
                'anamnese.anamneseColo',
                'anamnese.anamneseMama',
                'feedback',
            ])->where('cpf_paciente', $id)->latest()->first();
        }

        // Se ainda não encontrar, verifica se existe apenas o paciente cadastrado
        if (!$prontuario) {
            $paciente = Paciente::with(['endereco', 'telefones', 'prontuarios'])->find($id);
            if ($paciente && $paciente->prontuarios->isNotEmpty()) {
                $prontuario = $paciente->prontuarios()->with([
                    'paciente.endereco',
                    'paciente.telefones',
                    'cronograma.unidade',
                    'cronograma.vaga',
                    'cronograma.turno',
                    'anamnese.anamneseColo',
                    'anamnese.anamneseMama',
                    'feedback',
                ])->latest()->first();
            } else {
                abort(404, 'Prontuário do paciente não encontrado.');
            }
        }

        $paciente = $prontuario->paciente;
        $cronograma = $prontuario->cronograma;
        $anamnese = $prontuario->anamnese;

        // 2. Cálculo da idade e formatações
        $idade = $paciente && $paciente->data_nascimento
            ? Carbon::parse($paciente->data_nascimento)->age
            : null;

        // 3. Identifica tipo de anamnese (Siscolo / Sismama)
        $tipo_exame_nome = $cronograma?->vaga?->tipo_exame ?? 'Consulta Geral';
        $eh_siscolo = str_contains(strtolower($tipo_exame_nome), 'colo') || str_contains(strtolower($tipo_exame_nome), 'siscolo') || str_contains(strtolower($tipo_exame_nome), 'preventivo');
        $eh_sismama = str_contains(strtolower($tipo_exame_nome), 'mama') || str_contains(strtolower($tipo_exame_nome), 'sismama') || str_contains(strtolower($tipo_exame_nome), 'mamografia');

        return view('listaProntuario.prontuario_detalhado', [
            'prontuario' => $prontuario,
            'paciente' => $paciente,
            'cronograma' => $cronograma,
            'anamnese' => $anamnese,
            'idade' => $idade,
            'eh_siscolo' => $eh_siscolo,
            'eh_sismama' => $eh_sismama,
        ]);
    }
}