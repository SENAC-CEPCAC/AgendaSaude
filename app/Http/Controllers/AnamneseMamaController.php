<?php

namespace App\Http\Controllers;

use App\Models\AnamneseMama;
use Illuminate\Http\Request;

class AnamneseMamaController extends Controller
{
   
    public function index()
    {
        $anamnesesMama = AnamneseMama::all();

        return view('anamnese-mama.listar', ['anamnesesMama' => $anamnesesMama]);
    }

   
    public function create()
    {
        return view('anamnese-mama.criar');
    }

    
    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'id_fato_anamnese' => 'required|integer',
            'nodulo_mama_direita' => 'required|boolean',
            'nodulo_mama_esquerda' => 'required|boolean',
            'risco_elevado_cancer' => 'required|boolean',
            'mamas_examinadas_anteriormente' => 'nullable|boolean',
            'fez_mamografia_anterior' => 'required|boolean',
            'ano_ultima_mamografia' => 'nullable|integer|digits:4',
            'fez_radioterapia_mama' => 'required|boolean',
            'fez_cirurgia_mama' => 'required|boolean',
            'tipo_mamografia' => 'nullable|string|max:30',
            'achado_descarga_papilar_dir' => 'nullable|string|max:30',
            'achado_descarga_papilar_esq' => 'nullable|string|max:30',
            'achado_nodulo_localizacao_dir' => 'nullable|string|max:30',
            'achado_nodulo_localizacao_esq' => 'nullable|string|max:30',
            'achado_linfonodo_palpavel_dir' => 'nullable|string|max:30',
            'achado_linfonodo_palpavel_esq' => 'nullable|string|max:30',
        ]);

        AnamneseMama::create($dadosValidados);

        return redirect()
            ->route('anamnese-mama.index')
            ->with('sucesso', 'Anamnese de mama salva com sucesso!');
    }

    /**
     * Mostra os detalhes de uma anamnese de mama específica
     */
    public function show($id)
    {
        $anamneseMama = AnamneseMama::findOrFail($id);

        return view('anamnese-mama.detalhes', ['anamneseMama' => $anamneseMama]);
    }

    /**
     * Mostra o formulário de edição
     */
    public function edit($id)
    {
        $anamneseMama = AnamneseMama::findOrFail($id);

        return view('anamnese-mama.editar', ['anamneseMama' => $anamneseMama]);
    }

    /**
     * Atualiza uma anamnese de mama existente
     */
    public function update(Request $request, $id)
    {
        $dadosValidados = $request->validate([
            'id_fato_anamnese' => 'required|integer',
            'nodulo_mama_direita' => 'required|boolean',
            'nodulo_mama_esquerda' => 'required|boolean',
            'risco_elevado_cancer' => 'required|boolean',
            'mamas_examinadas_anteriormente' => 'nullable|boolean',
            'fez_mamografia_anterior' => 'required|boolean',
            'ano_ultima_mamografia' => 'nullable|integer|digits:4',
            'fez_radioterapia_mama' => 'required|boolean',
            'fez_cirurgia_mama' => 'required|boolean',
            'tipo_mamografia' => 'nullable|string|max:30',
            'achado_descarga_papilar_dir' => 'nullable|string|max:30',
            'achado_descarga_papilar_esq' => 'nullable|string|max:30',
            'achado_nodulo_localizacao_dir' => 'nullable|string|max:30',
            'achado_nodulo_localizacao_esq' => 'nullable|string|max:30',
            'achado_linfonodo_palpavel_dir' => 'nullable|string|max:30',
            'achado_linfonodo_palpavel_esq' => 'nullable|string|max:30',
        ]);

        AnamneseMama::findOrFail($id)->update($dadosValidados);

        return redirect()
            ->route('anamnese-mama.index')
            ->with('sucesso', 'Anamnese de mama atualizada com sucesso!');
    }

    /**
     * Exclui uma anamnese de mama
     */
    public function destroy($id)
    {
        AnamneseMama::findOrFail($id)->delete();

        return redirect()
            ->route('anamnese-mama.index')
            ->with('sucesso', 'Anamnese de mama excluída com sucesso!');
    }
}