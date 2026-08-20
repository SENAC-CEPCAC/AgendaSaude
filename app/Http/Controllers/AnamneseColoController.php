<?php

namespace App\Http\Controllers;

use App\Models\AnamneseColo;
use App\Models\FatoAnamnese;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnamneseColoController extends Controller
{
    /**
     * Lista todas as anamneses de colo
     */
    public function index()
    {
        // eager load do fatoAnamnese pra evitar consultas repetidas na view
        $anamnesesColo = AnamneseColo::with('fatoAnamnese')->get();

        return view('anamnese-colo.listar', ['anamnesesColo' => $anamnesesColo]);
    }

    /**
     * Mostra o formulário de criação
     */
    public function create($id_prontuario)
    {
        return view('anamnese.colo', ['id_prontuario' => $id_prontuario]);
    }

    /**
     * Salva uma nova anamnese de colo (cria fato_anamnese + anamnese_siscolo juntos)
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            // campos que vão pra tabela fato_anamnese
            'id_prontuario' => 'required|integer',
            'data_realizacao' => 'required|date',

            // campos que vão pra tabela anamnese_siscolo
            'motivo_exame' => 'required|string|max:50',
            'data_ultima_menstruacao' => 'nullable|date',
            'fez_preventivo_anterior' => 'required|boolean',
            'esta_gravida' => 'required|boolean',
            'usa_diu' => 'required|boolean',
            'usa_pilula' => 'required|boolean',
            'usa_hormonio_menopausa' => 'required|boolean',
            'ja_fez_radioterapia' => 'required|boolean',
            'sangramento_apos_relacao' => 'required|boolean',
            'sangramento_apos_menopausa' => 'required|boolean',
            'ano_ultimo_preventivo' => 'nullable|integer|digits:4',
            'inspecao_colo' => 'required|string|max:50',
            'sinais_dst' => 'nullable|string|max:30',
        ]);

        DB::transaction(function () use ($dados) {
            $fato = FatoAnamnese::create([
                'id_prontuario' => $dados['id_prontuario'],
                'id_profissional' => 1, // profissional logado no sistema
                'tipo_anamnese' => 'siscolo',
                'data_realizacao' => $dados['data_realizacao'],
            ]);

            AnamneseColo::create([
                'id_fato_anamnese' => $fato->id_fato_anamnese,
                'motivo_exame' => $dados['motivo_exame'],
                'data_ultima_menstruacao' => $dados['data_ultima_menstruacao'] ?? null,
                'fez_preventivo_anterior' => $dados['fez_preventivo_anterior'],
                'esta_gravida' => $dados['esta_gravida'],
                'usa_diu' => $dados['usa_diu'],
                'usa_pilula' => $dados['usa_pilula'],
                'usa_hormonio_menopausa' => $dados['usa_hormonio_menopausa'],
                'ja_fez_radioterapia' => $dados['ja_fez_radioterapia'],
                'sangramento_apos_relacao' => $dados['sangramento_apos_relacao'],
                'sangramento_apos_menopausa' => $dados['sangramento_apos_menopausa'],
                'ano_ultimo_preventivo' => $dados['ano_ultimo_preventivo'] ?? null,
                'inspecao_colo' => $dados['inspecao_colo'],
                'sinais_dst' => $dados['sinais_dst'] ?? null,
            ]);
        });

        return redirect()
            ->route('anamnese-colo.index')
            ->with('sucesso', 'Anamnese de colo salva com sucesso!');
    }


    public function show($id)
    {
        $anamneseColo = AnamneseColo::with('fatoAnamnese')->findOrFail($id);

        return view('anamnese-colo.detalhes', ['anamneseColo' => $anamneseColo]);
    }

    /**
     * Mostra o formulário de edição
     */
    public function edit($id)
    {
        $anamneseColo = AnamneseColo::with('fatoAnamnese')->findOrFail($id);

        return view('anamnese-colo.editar', ['anamneseColo' => $anamneseColo]);
    }


    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'id_prontuario' => 'required|integer',
            'data_realizacao' => 'required|date',
            'motivo_exame' => 'required|string|max:50',
            'data_ultima_menstruacao' => 'nullable|date',
            'fez_preventivo_anterior' => 'required|boolean',
            'esta_gravida' => 'required|boolean',
            'usa_diu' => 'required|boolean',
            'usa_pilula' => 'required|boolean',
            'usa_hormonio_menopausa' => 'required|boolean',
            'ja_fez_radioterapia' => 'required|boolean',
            'sangramento_apos_relacao' => 'required|boolean',
            'sangramento_apos_menopausa' => 'required|boolean',
            'ano_ultimo_preventivo' => 'nullable|integer|digits:4',
            'inspecao_colo' => 'required|string|max:50',
            'sinais_dst' => 'nullable|string|max:30',
        ]);

        DB::transaction(function () use ($dados, $id) {
            $anamneseColo = AnamneseColo::findOrFail($id);

            $anamneseColo->fatoAnamnese()->update([
                'id_prontuario' => $dados['id_prontuario'],
                'data_realizacao' => $dados['data_realizacao'],
            ]);

            $anamneseColo->update([
                'motivo_exame' => $dados['motivo_exame'],
                'data_ultima_menstruacao' => $dados['data_ultima_menstruacao'] ?? null,
                'fez_preventivo_anterior' => $dados['fez_preventivo_anterior'],
                'esta_gravida' => $dados['esta_gravida'],
                'usa_diu' => $dados['usa_diu'],
                'usa_pilula' => $dados['usa_pilula'],
                'usa_hormonio_menopausa' => $dados['usa_hormonio_menopausa'],
                'ja_fez_radioterapia' => $dados['ja_fez_radioterapia'],
                'sangramento_apos_relacao' => $dados['sangramento_apos_relacao'],
                'sangramento_apos_menopausa' => $dados['sangramento_apos_menopausa'],
                'ano_ultimo_preventivo' => $dados['ano_ultimo_preventivo'] ?? null,
                'inspecao_colo' => $dados['inspecao_colo'],
                'sinais_dst' => $dados['sinais_dst'] ?? null,
            ]);
        });

        return redirect()
            ->route('anamnese-colo.index')
            ->with('sucesso', 'Anamnese de colo atualizada com sucesso!');
    }


    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $anamneseColo = AnamneseColo::findOrFail($id);
            $fato = $anamneseColo->fatoAnamnese;

            $anamneseColo->delete();
            $fato?->delete();
        });

        return redirect()
            ->route('anamnese-colo.index')
            ->with('sucesso', 'Anamnese de colo excluída com sucesso!');
    }
}