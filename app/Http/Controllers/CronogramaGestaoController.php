<?php

namespace App\Http\Controllers;

use App\Models\CnesUnidade;
use App\Models\Cronograma;
use App\Models\Turno;
use App\Models\Vaga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CronogramaGestaoController extends Controller
{
    /**
     * Exibe a listagem, métricas e o calendário do Cronograma de Vagas para o Gestor N4.
     */
    public function index(Request $request)
    {
        // 1. Definição do mês e ano de filtro (padrão: mês atual)
        $mes_ano = $request->input('mes_ano', now()->format('Y-m'));
        $data_inicio = Carbon::parse($mes_ano . '-01')->startOfMonth();
        $data_fim = Carbon::parse($mes_ano . '-01')->endOfMonth();

        // 2. Consulta de cronogramas com filtros
        $query = Cronograma::with(['unidade', 'vaga', 'turno', 'prontuarios'])
            ->whereBetween('data_atendimento', [$data_inicio->format('Y-m-d'), $data_fim->format('Y-m-d')]);

        if ($request->filled('id_cnes_unidade')) {
            $query->where('id_cnes_unidade', $request->id_cnes_unidade);
        }

        if ($request->filled('id_vagas')) {
            $query->where('Vagas_id_vagas', $request->id_vagas);
        }

        if ($request->filled('id_turno')) {
            $query->where('Turno_id_turno', $request->id_turno);
        }

        $cronogramas = $query->orderBy('data_atendimento', 'asc')->get();

        // 3. Cálculo de Métricas Resumo do Mês
        $total_ofertadas = $cronogramas->sum('qnt_oferecidas_vagas');
        $total_preenchidas = $cronogramas->sum('prenchida_vagas');
        $total_restantes = max(0, $total_ofertadas - $total_preenchidas);
        $taxa_ocupacao = $total_ofertadas > 0 ? round(($total_preenchidas / $total_ofertadas) * 100, 1) : 0;
        $dias_atendimento = $cronogramas->pluck('data_atendimento')->unique()->count();

        // 4. Carregamento dos dados auxiliares para formulários e filtros
        $unidades = CnesUnidade::all();
        $vagas_tipos = Vaga::all();
        $turnos = Turno::all();

        return view('painel_adm.cronograma_vagas', [
            'cronogramas' => $cronogramas,
            'mes_ano' => $mes_ano,
            'total_ofertadas' => $total_ofertadas,
            'total_preenchidas' => $total_preenchidas,
            'total_restantes' => $total_restantes,
            'taxa_ocupacao' => $taxa_ocupacao,
            'dias_atendimento' => $dias_atendimento,
            'unidades' => $unidades,
            'vagas_tipos' => $vagas_tipos,
            'turnos' => $turnos,
            'filtros' => $request->all(),
        ]);
    }

    /**
     * Cadastra um ou múltiplos cronogramas de vagas (Suporta criação em lote).
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_cnes_unidade' => 'required|integer',
            'Vagas_id_vagas' => 'required|integer',
            'Turno_id_turno' => 'required|integer',
            'data_atendimento' => 'required|date',
            'data_fim_lote' => 'nullable|date|after_or_equal:data_atendimento',
            'municipio_atendimento' => 'required|string|max:100',
            'qnt_oferecidas_vagas' => 'required|integer|min:1|max:500',
            'replicar_dias_uteis' => 'nullable|boolean',
        ], [
            'id_cnes_unidade.required' => 'Selecione uma unidade móvel.',
            'Vagas_id_vagas.required' => 'Selecione o tipo de exame/vaga.',
            'Turno_id_turno.required' => 'Selecione o turno de atendimento.',
            'data_atendimento.required' => 'Informe a data de início.',
            'municipio_atendimento.required' => 'Informe o município ou localidade.',
            'qnt_oferecidas_vagas.required' => 'Informe a quantidade de vagas.',
            'qnt_oferecidas_vagas.min' => 'A quantidade mínima de vagas é 1.',
        ]);

        $criados = 0;

        DB::transaction(function () use ($dados, $request, &$criados) {
            $data_inicio = Carbon::parse($dados['data_atendimento']);
            $data_final = !empty($dados['data_fim_lote']) ? Carbon::parse($dados['data_fim_lote']) : $data_inicio;
            $replicar_uteis = $request->boolean('replicar_dias_uteis');

            $data_cursor = $data_inicio->copy();

            while ($data_cursor->lte($data_final)) {
                // Se replicar apenas dias úteis (Segunda a Sexta), pula sábado (6) e domingo (0)
                if ($replicar_uteis && $data_cursor->isWeekend()) {
                    $data_cursor->addDay();
                    continue;
                }

                // Cria ou atualiza o cronograma para o dia e turno especificados
                Cronograma::create([
                    'id_cnes_unidade' => $dados['id_cnes_unidade'],
                    'Vagas_id_vagas' => $dados['Vagas_id_vagas'],
                    'Turno_id_turno' => $dados['Turno_id_turno'],
                    'data_atendimento' => $data_cursor->format('Y-m-d'),
                    'municipio_atendimento' => $dados['municipio_atendimento'],
                    'qnt_oferecidas_vagas' => $dados['qnt_oferecidas_vagas'],
                    'prenchida_vagas' => 0,
                ]);

                $criados++;
                $data_cursor->addDay();
            }
        });

        $mensagem = $criados > 1
            ? "{$criados} cronogramas de vagas cadastrados com sucesso!"
            : "Cronograma de vagas cadastrado com sucesso!";

        return redirect()->route('cronograma.index', [
            'mes_ano' => Carbon::parse($dados['data_atendimento'])->format('Y-m')
        ])->with('sucesso', $mensagem);
    }

    /**
     * Atualiza os dados de um cronograma existente.
     */
    public function update(Request $request, $id)
    {
        $cronograma = Cronograma::findOrFail($id);

        $dados = $request->validate([
            'id_cnes_unidade' => 'required|integer',
            'Vagas_id_vagas' => 'required|integer',
            'Turno_id_turno' => 'required|integer',
            'data_atendimento' => 'required|date',
            'municipio_atendimento' => 'required|string|max:100',
            'qnt_oferecidas_vagas' => 'required|integer|min:1|max:500',
            'prenchida_vagas' => 'nullable|integer|min:0',
        ], [
            'id_cnes_unidade.required' => 'Selecione uma unidade móvel.',
            'Vagas_id_vagas.required' => 'Selecione o tipo de exame/vaga.',
            'Turno_id_turno.required' => 'Selecione o turno.',
            'data_atendimento.required' => 'Informe a data.',
            'municipio_atendimento.required' => 'Informe o município.',
            'qnt_oferecidas_vagas.required' => 'Informe a quantidade de vagas.',
        ]);

        $cronograma->update([
            'id_cnes_unidade' => $dados['id_cnes_unidade'],
            'Vagas_id_vagas' => $dados['Vagas_id_vagas'],
            'Turno_id_turno' => $dados['Turno_id_turno'],
            'data_atendimento' => $dados['data_atendimento'],
            'municipio_atendimento' => $dados['municipio_atendimento'],
            'qnt_oferecidas_vagas' => $dados['qnt_oferecidas_vagas'],
            'prenchida_vagas' => $dados['prenchida_vagas'] ?? $cronograma->prenchida_vagas,
        ]);

        return redirect()->back()->with('sucesso', 'Cronograma de vagas atualizado com sucesso!');
    }

    /**
     * Exclui um cronograma do sistema.
     */
    public function destroy($id)
    {
        $cronograma = Cronograma::withCount('prontuarios')->findOrFail($id);

        if ($cronograma->prontuarios_count > 0) {
            return redirect()->back()->with(
                'erro',
                "Não é possível excluir este cronograma pois existem {$cronograma->prontuarios_count} paciente(s) agendado(s) nele."
            );
        }

        $cronograma->delete();

        return redirect()->back()->with('sucesso', 'Cronograma de vagas excluído com sucesso!');
    }
}
