<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Triagem Administrativa N1 - Lista de Prontuários</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
  </head>
  <body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen">
    <div id="app-root" class="min-h-screen flex flex-col">
      @include('components.sidebar')

      <main id="main-content" class="min-h-screen flex-1 flex flex-col p-4 md:p-8 md:ml-64">
        <!-- Top Bar -->
        <header id="top-bar" class="h-16 bg-white border border-slate-200/80 px-4 md:px-6 flex items-center justify-between sticky top-4 z-20 shadow-sm rounded-xl mb-6">
          <div class="flex items-center gap-3">
            <div id="breadcrumb" class="flex items-center gap-2 text-xs text-slate-400 font-medium">
              <span>Portal Gestão N1</span>
              <span>/</span>
              <span class="text-slate-700 font-semibold">Triagem de Prontuários & Documentos</span>
            </div>
          </div>

          <div id="top-bar-actions" class="flex items-center gap-4">
            <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
              <div class="w-9 h-9 rounded-full bg-blue-50 border border-blue-200 flex items-center justify-center font-bold text-blue-900 text-xs">
                OP
              </div>
              <div class="hidden sm:block text-left">
                <p class="text-xs font-bold text-slate-700">Operador Triagem</p>
                <p class="text-[10px] text-slate-400 font-semibold leading-none mt-0.5">Nível 1 - Recepção</p>
              </div>
            </div>
          </div>
        </header>

        <div class="max-w-7xl w-full mx-auto space-y-6">
          
          <!-- Cabeçalho e Título -->
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <h1 class="text-2xl font-bold text-slate-900">Triagem de Prontuários (N1)</h1>
              <p class="text-sm text-slate-500 mt-0.5">Validação de documentos anexados (RG/CPF, Requisição) e controle de presença.</p>
            </div>

            <a href="{{ route('agendamento.etapa1') }}" target="_blank" class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-sm transition-all">
              <span class="material-symbols-outlined text-[18px]">add_circle</span>
              Novo Agendamento
            </a>
          </div>

          <!-- Mensagens Flash de Sucesso ou Erro -->
          @if (session('sucesso'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium flex items-center justify-between shadow-sm">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600 text-[20px]">check_circle</span>
                <span>{{ session('sucesso') }}</span>
              </div>
              <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
            </div>
          @endif

          @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-medium shadow-sm">
              <div class="flex items-center gap-2 font-bold mb-1">
                <span class="material-symbols-outlined text-rose-600 text-[20px]">error</span>
                Ocorreram erros na operação:
              </div>
              <ul class="list-disc list-inside text-xs space-y-1">
                @foreach ($errors->all() as $erro)
                  <li>{{ $erro }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Cards de Métricas da Triagem N1 -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
              <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Documentos Pendentes</p>
                <h3 class="text-2xl font-bold text-amber-600 mt-1">{{ $total_pendentes ?? 0 }}</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Aguardando conferência</p>
              </div>
              <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                <span class="material-symbols-outlined text-[26px]">hourglass_top</span>
              </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
              <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Documentos Aprovados</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $total_aprovados ?? 0 }}</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Triagem confirmada</p>
              </div>
              <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                <span class="material-symbols-outlined text-[26px]">verified</span>
              </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
              <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Documentos Rejeitados</p>
                <h3 class="text-2xl font-bold text-rose-600 mt-1">{{ $total_rejeitados ?? 0 }}</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Aguardando reanexação</p>
              </div>
              <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600">
                <span class="material-symbols-outlined text-[26px]">rule</span>
              </div>
            </div>
          </div>

          <!-- Barra de Pesquisa e Filtros -->
          <form method="GET" action="{{ route('triagem.index') }}" class="bg-white rounded-xl border border-slate-200/80 p-5 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
            <div class="relative w-full md:w-96 flex items-center">
              <span class="material-symbols-outlined absolute left-3 text-slate-400 text-[20px] pointer-events-none">search</span>
              <input
                type="text"
                name="busca"
                value="{{ $termo_busca }}"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:bg-white transition-all"
                placeholder="Buscar por paciente, CPF ou Nº..."
              >
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
              <!-- Filtro de Comparecimento -->
              <select
                name="status"
                onchange="this.form.submit()"
                class="bg-white border border-slate-200 text-slate-700 rounded-xl px-3 py-2 text-xs font-medium focus:outline-none focus:border-blue-900 transition-all cursor-pointer"
              >
                <option value="">Status Atendimento (Todos)</option>
                <option value="agendado" {{ $filtro_status === 'agendado' ? 'selected' : '' }}>Agendado</option>
                <option value="confirmado" {{ $filtro_status === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                <option value="espera" {{ $filtro_status === 'espera' ? 'selected' : '' }}>Lista de Espera</option>
                <option value="presente" {{ $filtro_status === 'presente' ? 'selected' : '' }}>Presente na Unidade</option>
                <option value="faltou" {{ $filtro_status === 'faltou' ? 'selected' : '' }}>Faltou</option>
                <option value="cancelado" {{ $filtro_status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
              </select>

              <!-- Filtro de Documento -->
              <select
                name="status_documento"
                onchange="this.form.submit()"
                class="bg-white border border-slate-200 text-slate-700 rounded-xl px-3 py-2 text-xs font-medium focus:outline-none focus:border-blue-900 transition-all cursor-pointer"
              >
                <option value="">Status Documentos (Todos)</option>
                <option value="pendente" {{ $filtro_documento === 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="aprovado" {{ $filtro_documento === 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                <option value="rejeitado" {{ $filtro_documento === 'rejeitado' ? 'selected' : '' }}>Rejeitado (Reanexar)</option>
              </select>

              @if($termo_busca || $filtro_status || $filtro_documento)
                <a href="{{ route('triagem.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Limpar</a>
              @endif
            </div>
          </form>

          <!-- Tabela de Prontuários e Triagem N1 -->
          <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                  <th class="py-4 px-5">Nº</th>
                  <th class="py-4 px-5">Paciente & CPF</th>
                  <th class="py-4 px-5">Exame / Unidade</th>
                  <th class="py-4 px-5">Data / Turno</th>
                  <th class="py-4 px-5 text-center">Status Presença</th>
                  <th class="py-4 px-5 text-center">Documentos N1</th>
                  <th class="py-4 px-5 text-center">Ações de Triagem</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                
                @forelse($lista_agendamentos as $agendamento)
                  <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="py-4 px-5 font-semibold text-slate-800">
                      #{{ $agendamento->id_prontuario }}
                    </td>

                    <!-- Paciente -->
                    <td class="py-4 px-5">
                      <div class="font-bold text-slate-800">
                        {{ $agendamento->paciente ? $agendamento->paciente->nome_completo : 'Paciente CPF ' . $agendamento->cpf_paciente }}
                      </div>
                      <div class="text-xs text-slate-400 font-mono mt-0.5">
                        CPF: {{ $agendamento->paciente ? $agendamento->paciente->cpf_paciente : ($agendamento->cpf_paciente ?? 'Não informado') }}
                      </div>
                    </td>

                    <!-- Exame & Unidade -->
                    <td class="py-4 px-5">
                      <span class="font-medium text-slate-700 block">
                        {{ $agendamento->cronograma?->vaga?->tipo_exame ?? 'Exame Preventivo' }}
                      </span>
                      <span class="text-xs text-slate-400">
                        {{ $agendamento->cronograma?->unidade?->nome_unidade ?? 'Unidade Móvel 01' }}
                      </span>
                    </td>

                    <!-- Data e Turno -->
                    <td class="py-4 px-5">
                      <span class="font-medium text-slate-700 block">
                        {{ $agendamento->cronograma ? \Carbon\Carbon::parse($agendamento->cronograma->data_atendimento)->format('d/m/Y') : now()->format('d/m/Y') }}
                      </span>
                      <span class="text-xs text-slate-400">
                        Turno: {{ $agendamento->cronograma?->turno?->turno ?? 'Manhã' }}
                      </span>
                    </td>

                    <!-- Status de Comparecimento -->
                    <td class="py-4 px-5 text-center">
                      @php
                        $status_cor = [
                          'agendado' => 'bg-blue-100 text-blue-800 border-blue-200',
                          'confirmado' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                          'espera' => 'bg-amber-100 text-amber-800 border-amber-200',
                          'presente' => 'bg-purple-100 text-purple-800 border-purple-200',
                          'faltou' => 'bg-slate-100 text-slate-800 border-slate-200',
                          'cancelado' => 'bg-rose-100 text-rose-800 border-rose-200',
                        ][$agendamento->status_comparecimento] ?? 'bg-slate-100 text-slate-700';
                      @endphp
                      <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $status_cor }}">
                        {{ ucfirst($agendamento->status_comparecimento) }}
                      </span>
                    </td>

                    <!-- Status do Documento -->
                    <td class="py-4 px-5 text-center">
                      @if($agendamento->status_documento === 'aprovado')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                          <span class="material-symbols-outlined text-[14px]">check</span> Aprovado
                        </span>
                      @elseif($agendamento->status_documento === 'rejeitado')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200" title="{{ $agendamento->motivo_rejeicao_documento }}">
                          <span class="material-symbols-outlined text-[14px]">close</span> Rejeitado
                        </span>
                      @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                          <span class="material-symbols-outlined text-[14px]">pending</span> Pendente
                        </span>
                      @endif
                    </td>

                    <!-- Ações de Triagem -->
                    <td class="py-4 px-5 text-center">
                      <div class="flex items-center justify-center gap-1.5">
                        
                        <!-- Ver Documentos -->
                        <button
                          type="button"
                          onclick="abrirModalDocumentos('{{ $agendamento->id_prontuario }}', '{{ $agendamento->caminho_documento_rg_cpf ? asset('storage/' . $agendamento->caminho_documento_rg_cpf) : '' }}', '{{ $agendamento->caminho_documento_requisicao ? asset('storage/' . $agendamento->caminho_documento_requisicao) : '' }}', '{{ $agendamento->paciente?->nome_completo }}')"
                          class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors"
                          title="Ver Documentos Anexados"
                        >
                          <span class="material-symbols-outlined text-[18px]">description</span>
                        </button>

                        <!-- Avaliar Documentos (Aprovar / Rejeitar) -->
                        <button
                          type="button"
                          onclick="abrirModalAvaliacao('{{ $agendamento->id_prontuario }}', '{{ $agendamento->paciente?->nome_completo }}')"
                          class="p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-900 rounded-lg transition-colors"
                          title="Avaliar Triagem N1"
                        >
                          <span class="material-symbols-outlined text-[18px]">verified</span>
                        </button>

                        <!-- Alterar Status de Comparecimento -->
                        <button
                          type="button"
                          onclick="abrirModalStatus('{{ $agendamento->id_prontuario }}', '{{ $agendamento->status_comparecimento }}', '{{ $agendamento->paciente?->nome_completo }}')"
                          class="p-1.5 bg-purple-50 hover:bg-purple-100 text-purple-900 rounded-lg transition-colors"
                          title="Alterar Presença / Comparecimento"
                        >
                          <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
                        </button>

                        <!-- Reanexar Documento -->
                        <button
                          type="button"
                          onclick="abrirModalReanexar('{{ $agendamento->id_prontuario }}', '{{ $agendamento->paciente?->nome_completo }}')"
                          class="p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-800 rounded-lg transition-colors"
                          title="Substituir / Reanexar Arquivo"
                        >
                          <span class="material-symbols-outlined text-[18px]">upload</span>
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="py-12 text-center text-slate-400 font-medium">
                      <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">inbox</span>
                      Nenhum agendamento encontrado para os filtros selecionados.
                    </td>
                  </tr>
                @endforelse

              </tbody>
            </table>
          </div>

          <!-- Paginação -->
          <div class="pt-2">
            {{ $lista_agendamentos->withQueryString()->links() }}
          </div>
        </div>
      </main>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL 1: VISUALIZAÇÃO DE DOCUMENTOS (RG/CPF & REQUISIÇÃO) -->
    <!-- ======================================================== -->
    <div id="modal-documentos" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
      <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-slate-200 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
          <div>
            <h3 class="text-base font-bold text-slate-800">Documentos Anexados</h3>
            <p id="modal-doc-paciente" class="text-xs text-slate-400"></p>
          </div>
          <button onclick="fecharModais()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold">&times;</button>
        </div>

        <div class="space-y-4">
          <!-- RG/CPF -->
          <div class="border border-slate-200 rounded-xl p-4 bg-slate-50">
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[18px] text-blue-900">badge</span>
              Documento de Identificação (RG / CPF)
            </h4>
            <div id="container-preview-rg" class="flex flex-col items-center justify-center min-h-32 bg-white rounded-lg border border-slate-200 p-2">
              <!-- Renderizado via JS -->
            </div>
          </div>

          <!-- Requisição Médica -->
          <div class="border border-slate-200 rounded-xl p-4 bg-slate-50">
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[18px] text-blue-900">receipt_long</span>
              Requisição Médica
            </h4>
            <div id="container-preview-req" class="flex flex-col items-center justify-center min-h-32 bg-white rounded-lg border border-slate-200 p-2">
              <!-- Renderizado via JS -->
            </div>
          </div>
        </div>

        <div class="flex justify-end pt-2">
          <button type="button" onclick="fecharModais()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition-colors">
            Fechar Visualização
          </button>
        </div>
      </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL 2: AVALIAÇÃO DE TRIAGEM (APROVAR OU REJEITAR N1)   -->
    <!-- ======================================================== -->
    <div id="modal-avaliacao" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
      <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
          <h3 class="text-base font-bold text-slate-800">Avaliação de Triagem N1</h3>
          <button onclick="fecharModais()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold">&times;</button>
        </div>

        <form id="form-avaliacao-documento" method="POST" action="" class="space-y-4">
          @csrf
          <p id="modal-aval-paciente" class="text-xs text-slate-500"></p>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Decisão de Triagem</label>
            <div class="grid grid-cols-2 gap-2">
              <label class="cursor-pointer border border-slate-200 rounded-lg p-3 flex items-center gap-2 hover:bg-slate-50 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50">
                <input type="radio" name="status_documento" value="aprovado" checked onchange="toggleMotivoRejeicao(false)" class="text-emerald-600">
                <span class="text-xs font-bold text-emerald-800">Aprovar</span>
              </label>

              <label class="cursor-pointer border border-slate-200 rounded-lg p-3 flex items-center gap-2 hover:bg-slate-50 has-[:checked]:border-rose-600 has-[:checked]:bg-rose-50">
                <input type="radio" name="status_documento" value="rejeitado" onchange="toggleMotivoRejeicao(true)" class="text-rose-600">
                <span class="text-xs font-bold text-rose-800">Rejeitar</span>
              </label>
            </div>
          </div>

          <div id="box-motivo-rejeicao" class="hidden">
            <label class="block text-xs font-bold text-slate-700 mb-1">Motivo da Rejeição (para reanexação)</label>
            <textarea
              name="motivo_rejeicao_documento"
              rows="3"
              placeholder="Ex: Foto do RG com reflexo/ilegível. Favor enviar foto nítida do documento aberto."
              class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-xs text-slate-700 focus:outline-none focus:border-blue-900"
            ></textarea>
          </div>

          <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
            <button type="button" onclick="fecharModais()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg">
              Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-bold rounded-lg shadow-sm">
              Confirmar Avaliação
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL 3: ALTERAÇÃO DE STATUS DE COMPARECIMENTO            -->
    <!-- ======================================================== -->
    <div id="modal-status" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
      <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
          <h3 class="text-base font-bold text-slate-800">Alterar Status de Presença</h3>
          <button onclick="fecharModais()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold">&times;</button>
        </div>

        <form id="form-alterar-status" method="POST" action="" class="space-y-4">
          @csrf
          @method('PATCH')
          <p id="modal-status-paciente" class="text-xs text-slate-500"></p>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Novo Status</label>
            <select name="status_comparecimento" id="select-modal-status" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-xs text-slate-700 focus:outline-none focus:border-blue-900">
              <option value="agendado">Agendado</option>
              <option value="confirmado">Confirmado</option>
              <option value="presente">Presente na Unidade Móvel</option>
              <option value="espera">Lista de Espera</option>
              <option value="faltou">Faltou</option>
              <option value="cancelado">Cancelado</option>
            </select>
          </div>

          <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
            <button type="button" onclick="fecharModais()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg">
              Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-bold rounded-lg shadow-sm">
              Salvar Alteração
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL 4: REANEXAR DOCUMENTO (SUBSTITUIÇÃO DE ARQUIVO)    -->
    <!-- ======================================================== -->
    <div id="modal-reanexar" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
      <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
          <h3 class="text-base font-bold text-slate-800">Reanexar Documento</h3>
          <button onclick="fecharModais()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold">&times;</button>
        </div>

        <form id="form-reanexar-documento" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
          @csrf
          <p id="modal-reanexar-paciente" class="text-xs text-slate-500"></p>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Novo RG/CPF (máx 5MB)</label>
            <input type="file" name="novo_documento_rg_cpf" accept="image/*,application/pdf" class="w-full text-xs text-slate-600 bg-slate-50 border border-slate-200 rounded-lg p-2">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Nova Requisição Médica (máx 5MB)</label>
            <input type="file" name="novo_documento_requisicao" accept="image/*,application/pdf" class="w-full text-xs text-slate-600 bg-slate-50 border border-slate-200 rounded-lg p-2">
          </div>

          <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
            <button type="button" onclick="fecharModais()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg">
              Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-bold rounded-lg shadow-sm">
              Enviar e Substituir
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Scripts dos Modais e Interações -->
    <script>
      function fecharModais() {
        document.querySelectorAll('#modal-documentos, #modal-avaliacao, #modal-status, #modal-reanexar').forEach(m => {
          m.classList.add('hidden');
          m.classList.remove('flex');
        });
      }

      function abrirModalDocumentos(id, urlRg, urlReq, nomePaciente) {
        document.getElementById('modal-doc-paciente').textContent = 'Agendamento #' + id + ' • ' + (nomePaciente || '');

        const containerRg = document.getElementById('container-preview-rg');
        if (urlRg) {
          if (urlRg.endsWith('.pdf')) {
            containerRg.innerHTML = '<a href="' + urlRg + '" target="_blank" class="text-xs text-blue-900 font-bold flex items-center gap-1 underline"><span class="material-symbols-outlined">picture_as_pdf</span> Abrir Documento PDF em Nova Aba</a>';
          } else {
            containerRg.innerHTML = '<img src="' + urlRg + '" class="max-h-56 object-contain rounded-lg shadow-sm" alt="RG/CPF">';
          }
        } else {
          containerRg.innerHTML = '<span class="text-xs text-slate-400 italic">Nenhum documento de RG/CPF anexado.</span>';
        }

        const containerReq = document.getElementById('container-preview-req');
        if (urlReq) {
          if (urlReq.endsWith('.pdf')) {
            containerReq.innerHTML = '<a href="' + urlReq + '" target="_blank" class="text-xs text-blue-900 font-bold flex items-center gap-1 underline"><span class="material-symbols-outlined">picture_as_pdf</span> Abrir Requisição PDF em Nova Aba</a>';
          } else {
            containerReq.innerHTML = '<img src="' + urlReq + '" class="max-h-56 object-contain rounded-lg shadow-sm" alt="Requisição">';
          }
        } else {
          containerReq.innerHTML = '<span class="text-xs text-slate-400 italic">Nenhuma requisição médica anexada (opcional).</span>';
        }

        const modal = document.getElementById('modal-documentos');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function abrirModalAvaliacao(id, nomePaciente) {
        document.getElementById('modal-aval-paciente').textContent = 'Agendamento #' + id + ' • ' + (nomePaciente || '');
        document.getElementById('form-avaliacao-documento').action = '/agendamento/' + id + '/avaliar-documento';
        toggleMotivoRejeicao(false);

        const modal = document.getElementById('modal-avaliacao');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function toggleMotivoRejeicao(mostrar) {
        const box = document.getElementById('box-motivo-rejeicao');
        if (mostrar) {
          box.classList.remove('hidden');
        } else {
          box.classList.add('hidden');
        }
      }

      function abrirModalStatus(id, statusAtual, nomePaciente) {
        document.getElementById('modal-status-paciente').textContent = 'Agendamento #' + id + ' • ' + (nomePaciente || '');
        document.getElementById('form-alterar-status').action = '/agendamento/' + id + '/status';
        document.getElementById('select-modal-status').value = statusAtual || 'agendado';

        const modal = document.getElementById('modal-status');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function abrirModalReanexar(id, nomePaciente) {
        document.getElementById('modal-reanexar-paciente').textContent = 'Agendamento #' + id + ' • ' + (nomePaciente || '');
        document.getElementById('form-reanexar-documento').action = '/agendamento/' + id + '/reanexar-documento';

        const modal = document.getElementById('modal-reanexar');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }
    </script>
  </body>
</html>
