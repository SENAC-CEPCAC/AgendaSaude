<?php

namespace App\Http\Controllers;

use App\Models\CnesUnidade;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CnesUnidadeController extends Controller
{
    /**
     * Lista as unidades CNES (com busca opcional por código ou nome).
     */
    public function index(Request $request): View
    {
        $unidades = CnesUnidade::query()
            ->when($request->filled('busca'), function ($query) use ($request) {
                $termo = $request->input('busca');
                $query->where('codigo_cnes', 'like', "%{$termo}%")
                      ->orWhere('nome_unidade', 'like', "%{$termo}%");
            })
            ->orderBy('nome_unidade')
            ->paginate(15);

        return view('anamnese.unidadesmoveis', [
            'unidades' => $unidades,
            'busca' => $request->input('busca'),
        ]);
    }

    /**
     * Salva uma nova unidade CNES.
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'codigo_cnes' => 'required|string|max:20|unique:dim_cnes_unidades,codigo_cnes',
            'nome_unidade' => 'required|string|max:150',
        ]);

        CnesUnidade::create($dados);

        return redirect()
            ->route('unidadesmoveis.index')
            ->with('sucesso', 'Unidade CNES criada com sucesso.');
    }

    /**
     * Atualiza uma unidade CNES existente.
     */
    public function update(Request $request, CnesUnidade $cnesUnidade): RedirectResponse
    {
        $dados = $request->validate([
            'codigo_cnes' => 'required|string|max:20|unique:dim_cnes_unidades,codigo_cnes,' . $cnesUnidade->id_cnes_unidade . ',id_cnes_unidade',
            'nome_unidade' => 'required|string|max:150',
        ]);

        $cnesUnidade->update($dados);

        return redirect()
            ->route('unidadesmoveis.index')
            ->with('sucesso', 'Unidade CNES atualizada com sucesso.');
    }

    /**
     * Remove uma unidade CNES.
     */
    public function destroy(CnesUnidade $cnesUnidade): RedirectResponse
    {
        $cnesUnidade->delete();

        return redirect()
            ->route('unidadesmoveis.index')
            ->with('sucesso', 'Unidade CNES removida.');
    }
}
