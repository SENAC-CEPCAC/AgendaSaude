<?php
// app/Http/Controllers/CnesUnidadeController.php

namespace App\Http\Controllers;

use App\Models\CnesUnidade;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CnesUnidadeController extends Controller
{
    /**
     * Lista as unidades CNES (com busca opcional por código ou nome).
     * Rota: GET /cnes-unidades
     */
    public function index(Request $request): View
    {
        $unidades = CnesUnidade::query()
            ->buscar($request->input('busca'))
            ->orderBy('nome_unidade')
            ->paginate(15);

        return view('cnes-unidades.index', [
            'unidades' => $unidades,
            'busca' => $request->input('busca'),
        ]);
    }

    /**
     * Formulário de criação.
     * Rota: GET /cnes-unidades/criar
     */
    public function create(): View
    {
        return view('cnes-unidades.criar');
    }

    /**
     * Salva uma nova unidade CNES.
     * Rota: POST /cnes-unidades
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'codigo_cnes' => 'required|string|max:20|unique:dim_cnes_unidades,codigo_cnes',
            'nome_unidade' => 'required|string|max:150',
        ]);

        CnesUnidade::create($dados);

        return redirect()
            ->route('cnes-unidades.index')
            ->with('sucesso', 'Unidade CNES criada com sucesso.');
    }

    /**
     * Mostra os detalhes de uma unidade.
     * Rota: GET /cnes-unidades/{cnesUnidade}
     *
     * Obs: como a chave primária não é "id", é preciso indicar isso
     * na rota (veja routes-cnes-unidades.php) para o Route Model Binding funcionar.
     */
    public function show(CnesUnidade $cnesUnidade): View
    {
        return view('cnes-unidades.detalhes', [
            'unidade' => $cnesUnidade,
        ]);
    }

    /**
     * Formulário de edição.
     * Rota: GET /cnes-unidades/{cnesUnidade}/editar
     */
    public function edit(CnesUnidade $cnesUnidade): View
    {
        return view('cnes-unidades.editar', [
            'unidade' => $cnesUnidade,
        ]);
    }

    /**
     * Atualiza uma unidade CNES existente.
     * Rota: PUT/PATCH /cnes-unidades/{cnesUnidade}
     */
    public function update(Request $request, CnesUnidade $cnesUnidade): RedirectResponse
    {
        $dados = $request->validate([
            'codigo_cnes' => 'required|string|max:20|unique:dim_cnes_unidades,codigo_cnes,' . $cnesUnidade->id_cnes_unidade . ',id_cnes_unidade',
            'nome_unidade' => 'required|string|max:150',
        ]);

        $cnesUnidade->update($dados);

        return redirect()
            ->route('cnes-unidades.index')
            ->with('sucesso', 'Unidade CNES atualizada com sucesso.');
    }

    /**
     * Remove uma unidade CNES.
     * Rota: DELETE /cnes-unidades/{cnesUnidade}
     */
    public function destroy(CnesUnidade $cnesUnidade): RedirectResponse
    {
        $cnesUnidade->delete();

        return redirect()
            ->route('cnes-unidades.index')
            ->with('sucesso', 'Unidade CNES removida.');
    }
}