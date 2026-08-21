<?php

namespace App\Http\Controllers;

use App\Models\AnamneseMama;
use App\Models\FatoAnamnese;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AnamneseMamaController extends Controller
{
    /**
     * Lista todas as anamneses de mama, com busca opcional por CPF
     */
    public function index(Request $request)
    {
        $cpfBusca = $request->query('cpf');

        $anamnesesMama = AnamneseMama::with('fatoAnamnese.prontuario.paciente')
            ->when($cpfBusca, function ($query, $cpfBusca) {
                $cpfLimpo = preg_replace('/\D/', '', $cpfBusca);

                $query->whereHas('fatoAnamnese.prontuario.paciente', function ($q) use ($cpfLimpo) {
                    $q->where('cpf_paciente', 'like', '%' . $cpfLimpo . '%');
                });
            })
            ->latest('id_sismama')
            ->get();

        return view('anamnese-mama.listar', [
            'anamnesesMama' => $anamnesesMama,
            'cpfBusca' => $cpfBusca,
        ]);
    }

    /**
     * Mostra o formulário de criação
     */
    public function create($id_prontuario)
    {
        return view('anamnese.mama', ['id_prontuario' => $id_prontuario]);
    }

    /**
     * Salva uma nova anamnese de mama (cria fato_anamnese + anamnese_sismama juntos)
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_prontuario' => 'required|integer',
            'data_realizacao' => 'required|date',

            'nodulo_mama_direita' => 'required|boolean',
            'nodulo_mama_esquerda' => 'required|boolean',
            'risco_elevado_cancer' => 'required|boolean',
            'mamas_examinadas_anteriormente' => 'required|boolean',
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

        DB::transaction(function () use ($dados) {
            $fato = FatoAnamnese::create([
                'id_prontuario' => $dados['id_prontuario'],
                'id_profissional' => auth()->id() ?? 1, // TEMPORÁRIO: fixo até o login estar pronto
                'tipo_anamnese' => 'sismama',
                'data_realizacao' => $dados['data_realizacao'],
            ]);

            AnamneseMama::create([
                'id_fato_anamnese' => $fato->id_fato_anamnese,
                'nodulo_mama_direita' => $dados['nodulo_mama_direita'],
                'nodulo_mama_esquerda' => $dados['nodulo_mama_esquerda'],
                'risco_elevado_cancer' => $dados['risco_elevado_cancer'],
                'mamas_examinadas_anteriormente' => $dados['mamas_examinadas_anteriormente'],
                'fez_mamografia_anterior' => $dados['fez_mamografia_anterior'],
                'ano_ultima_mamografia' => $dados['ano_ultima_mamografia'] ?? null,
                'fez_radioterapia_mama' => $dados['fez_radioterapia_mama'],
                'fez_cirurgia_mama' => $dados['fez_cirurgia_mama'],
                'tipo_mamografia' => $dados['tipo_mamografia'] ?? null,
                'achado_descarga_papilar_dir' => $dados['achado_descarga_papilar_dir'] ?? null,
                'achado_descarga_papilar_esq' => $dados['achado_descarga_papilar_esq'] ?? null,
                'achado_nodulo_localizacao_dir' => $dados['achado_nodulo_localizacao_dir'] ?? null,
                'achado_nodulo_localizacao_esq' => $dados['achado_nodulo_localizacao_esq'] ?? null,
                'achado_linfonodo_palpavel_dir' => $dados['achado_linfonodo_palpavel_dir'] ?? null,
                'achado_linfonodo_palpavel_esq' => $dados['achado_linfonodo_palpavel_esq'] ?? null,
            ]);
        });

        return redirect()
            ->route('anamnese-mama.index')
            ->with('sucesso', 'Anamnese de mama salva com sucesso!');
    }

    public function show($id)
    {
        $anamneseMama = AnamneseMama::with('fatoAnamnese.prontuario.paciente')->findOrFail($id);

        return view('anamnese-mama.detalhes', ['anamneseMama' => $anamneseMama]);
    }

    public function edit($id)
    {
        $anamneseMama = AnamneseMama::with('fatoAnamnese')->findOrFail($id);

        return view('anamnese-mama.editar', ['anamneseMama' => $anamneseMama]);
    }

    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'id_prontuario' => 'required|integer',
            'data_realizacao' => 'required|date',
            'nodulo_mama_direita' => 'required|boolean',
            'nodulo_mama_esquerda' => 'required|boolean',
            'risco_elevado_cancer' => 'required|boolean',
            'mamas_examinadas_anteriormente' => 'required|boolean',
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

        DB::transaction(function () use ($dados, $id) {
            $anamneseMama = AnamneseMama::findOrFail($id);

            $anamneseMama->fatoAnamnese()->update([
                'id_prontuario' => $dados['id_prontuario'],
                'data_realizacao' => $dados['data_realizacao'],
            ]);

            $anamneseMama->update([
                'nodulo_mama_direita' => $dados['nodulo_mama_direita'],
                'nodulo_mama_esquerda' => $dados['nodulo_mama_esquerda'],
                'risco_elevado_cancer' => $dados['risco_elevado_cancer'],
                'mamas_examinadas_anteriormente' => $dados['mamas_examinadas_anteriormente'],
                'fez_mamografia_anterior' => $dados['fez_mamografia_anterior'],
                'ano_ultima_mamografia' => $dados['ano_ultima_mamografia'] ?? null,
                'fez_radioterapia_mama' => $dados['fez_radioterapia_mama'],
                'fez_cirurgia_mama' => $dados['fez_cirurgia_mama'],
                'tipo_mamografia' => $dados['tipo_mamografia'] ?? null,
                'achado_descarga_papilar_dir' => $dados['achado_descarga_papilar_dir'] ?? null,
                'achado_descarga_papilar_esq' => $dados['achado_descarga_papilar_esq'] ?? null,
                'achado_nodulo_localizacao_dir' => $dados['achado_nodulo_localizacao_dir'] ?? null,
                'achado_nodulo_localizacao_esq' => $dados['achado_nodulo_localizacao_esq'] ?? null,
                'achado_linfonodo_palpavel_dir' => $dados['achado_linfonodo_palpavel_dir'] ?? null,
                'achado_linfonodo_palpavel_esq' => $dados['achado_linfonodo_palpavel_esq'] ?? null,
            ]);
        });

        return redirect()
            ->route('anamnese-mama.index')
            ->with('sucesso', 'Anamnese de mama atualizada com sucesso!');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $anamneseMama = AnamneseMama::findOrFail($id);
            $fato = $anamneseMama->fatoAnamnese;

            $anamneseMama->delete();
            $fato?->delete();
        });

        return redirect()
            ->route('anamnese-mama.index')
            ->with('sucesso', 'Anamnese de mama excluída com sucesso!');
    }

    /**
     * Gera o PDF da ficha individual de uma anamnese
     */
    public function pdf($id)
    {
        $anamneseMama = AnamneseMama::with('fatoAnamnese.prontuario.paciente')->findOrFail($id);

        $pdf = Pdf::loadView('anamnese-mama.pdf', ['anamneseMama' => $anamneseMama]);

        return $pdf->download('anamnese-mama-' . $id . '.pdf');
    }
}