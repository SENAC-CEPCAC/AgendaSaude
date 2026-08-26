<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Meu Perfil - Agenda Saúde</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

  <!-- Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'monospace'],
          }
        }
      }
    }
  </script>
</head>

<body class="bg-[#f8fafc] text-slate-800 font-sans antialiased min-h-screen">

  @php
    $usuarioNome = $colaborador?->nome ?? $paciente?->nome_completo ?? $usuario?->nome ?? $usuario?->name ?? 'Usuário';

    // Rótulo de perfil e rota de retorno
    $labelPerfil = match($nivelUsuario) {
      4 => 'Portal de Gestão & Administração',
      3 => 'Portal de Triagem & Clínico',
      2 => 'Portal do Colaborador (Recepção)',
      default => 'Portal do Paciente',
    };

    $cargoDescricao = match($nivelUsuario) {
      4 => 'Gestor / Administrador Geral (Nível 4)',
      3 => 'Médico / Triagista / Enfermagem (Nível 3)',
      2 => 'Operador de Recepção & Agendamento (Nível 2)',
      default => 'Paciente Cadastrado (Nível 1)',
    };

    $rotaRetorno = match($nivelUsuario) {
      4 => route('painel_adm.dashboard'),
      3 => route('triagem.index'),
      2 => route('agendamentos.index'),
      default => route('agendamento.agendamentos'),
    };

    // Formatações paciente
    $cpfFormatado = $cpfLimpo ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpfLimpo) : 'Não informado';
    $susFormatado = $paciente?->cartao_sus ? preg_replace('/(\d{3})(\d{4})(\d{4})(\d{4})/', '$1 $2 $3 $4', $paciente->cartao_sus) : ($paciente?->cartao_sus ?? 'Não informado');
    
    $idade = null;
    if ($paciente?->data_nascimento) {
      $idade = \Carbon\Carbon::parse($paciente->data_nascimento)->age;
    }

    $telNumero = $telefone?->numero ?? '';
    if (strlen($telNumero) == 11) {
      $telFormatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telNumero);
    } elseif (strlen($telNumero) == 10) {
      $telFormatado = preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telNumero);
    } else {
      $telFormatado = $telNumero;
    }

    // Iniciais do nome
    $iniciais = collect(explode(' ', $usuarioNome))
      ->filter()
      ->take(2)
      ->map(fn($part) => mb_substr($part, 0, 1))
      ->join('');
  @endphp

  <!-- BOTÃO DO MENU HAMBÚRGUER (Mesma cor do botão Novo Agendamento: bg-blue-900) -->
  <button id="mobile-menu-toggle" type="button" class="fixed left-3 top-3 z-[60] flex items-center justify-center rounded-lg bg-blue-900 p-2 text-white shadow-md transition hover:bg-blue-800 sm:left-5 sm:top-5 cursor-pointer" aria-controls="sidebar" aria-expanded="false" aria-label="Abrir menu">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
      <path d="M4 5h16"></path>
      <path d="M4 12h16"></path>
      <path d="M4 19h16"></path>
    </svg>
  </button>

  <!-- Overlay para fechar sidebar mobile -->
  <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden opacity-0 transition-opacity duration-300"></div>

  <!-- Sidebar Dinâmica conforme o Nível do Usuário -->
  @if ($nivelUsuario === 4)
    @include('sidebar.sidebar_n4')
  @elseif ($nivelUsuario === 3)
    @include('sidebar.sidebar_n3')
  @else
    @include('sidebar.sidebar_n1_n2')
  @endif

  <div id="app-root" class="min-h-screen bg-[#f8fafc]">

    <!-- Top Bar / Header -->
    <header id="top-bar" class="h-16 px-4 md:px-8 flex items-center justify-between sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-xs">
      <div class="flex items-center gap-3 pl-12 sm:pl-14">
        <span class="text-xs font-semibold uppercase tracking-wider text-blue-900 bg-blue-50 px-2.5 py-1 rounded-md">
          {{ $labelPerfil }}
        </span>
      </div>

      <div class="flex items-center gap-3">
        <a href="{{ $rotaRetorno }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 hover:text-blue-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
          Voltar ao Painel
        </a>
      </div>
    </header>

    <!-- Conteúdo Principal -->
    <main id="main-content" class="max-w-5xl w-full mx-auto p-4 sm:p-6 md:p-8 space-y-6">

      <!-- Notificações de Sucesso ou Erro -->
      @if (session('success'))
        <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 flex items-start gap-3 shadow-xs animate-fade-in">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
          <div class="text-sm font-medium">
            {{ session('success') }}
          </div>
        </div>
      @endif

      @if ($errors->any())
        <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-800 flex items-start gap-3 shadow-xs">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
          <div class="text-sm space-y-1">
            <strong class="font-semibold block">Por favor, revise os campos:</strong>
            <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-700">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      @endif

      <!-- Banner de Cabeçalho do Perfil -->
      <div class="bg-gradient-to-r from-blue-900 to-slate-900 rounded-2xl p-6 sm:p-8 text-white shadow-md relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
          <svg width="240" height="240" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 relative z-10">
          <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-2xl sm:text-3xl font-bold text-white shadow-inner shrink-0">
            {{ $iniciais ?: 'U' }}
          </div>

          <div class="space-y-1.5 flex-1">
            <div class="flex flex-wrap items-center gap-2">
              <h1 class="text-xl sm:text-2xl font-bold tracking-tight">
                {{ $usuarioNome }}
              </h1>
              <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[11px] font-semibold px-2.5 py-0.5 rounded-full flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Conta Ativa
              </span>
            </div>

            <p class="text-xs sm:text-sm text-slate-300">
              {{ $cargoDescricao }}
            </p>

            <div class="flex flex-wrap items-center gap-3 pt-1 text-xs text-slate-300 font-mono">
              @if ($nivelUsuario === 1)
                <span class="bg-white/10 px-2.5 py-1 rounded-md">CPF: {{ $cpfFormatado }}</span>
                <span class="bg-white/10 px-2.5 py-1 rounded-md">SUS: {{ $susFormatado }}</span>
              @else
                <span class="bg-white/10 px-2.5 py-1 rounded-md">Matrícula: {{ $colaborador?->matricula ?? 'ADM-'.str_pad($usuario->id ?? 1, 4, '0', STR_PAD_LEFT) }}</span>
                <span class="bg-white/10 px-2.5 py-1 rounded-md">Cidade: {{ $colaborador?->cidade ?? 'Salvador' }}</span>
                <span class="bg-white/10 px-2.5 py-1 rounded-md">E-mail: {{ $colaborador?->email ?? $usuario->email }}</span>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- FORMULÁRIO DE EDIÇÃO DO PERFIL -->
      <form action="{{ route('paciente.perfil.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @if ($nivelUsuario >= 2)
          <!-- ========================================================================= -->
          <!-- FORMULÁRIO PARA COLABORADORES E GESTORES (NÍVEIS 2, 3 E 4)                -->
          <!-- ========================================================================= -->

          <!-- 1. Identificação Institucional (Bloqueados) -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
              <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>
                </div>
                <div>
                  <h2 class="text-base font-bold text-slate-900">Identificação Funcional & Institucional (Inalteráveis)</h2>
                  <p class="text-xs text-slate-500">Dados corporativos vinculados ao registro funcional e permissões atribuídas.</p>
                </div>
              </div>
              <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200/60 w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Campos Bloqueados
              </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
              <!-- Matrícula -->
              <div class="space-y-1.5">
                <label class="text-xs font-semibold text-slate-600 flex items-center justify-between">
                  <span>Matrícula Funcional</span>
                  <span class="text-[10px] text-slate-400 font-mono">🔒 Imutável</span>
                </label>
                <input type="text" value="{{ $colaborador?->matricula ?? 'ADM-'.str_pad($usuario->id ?? 1, 4, '0', STR_PAD_LEFT) }}" disabled class="w-full bg-slate-100 border border-slate-200 text-slate-700 font-mono rounded-xl py-2.5 px-3.5 text-sm cursor-not-allowed select-none">
              </div>

              <!-- Nível de Permissão -->
              <div class="space-y-1.5">
                <label class="text-xs font-semibold text-slate-600 flex items-center justify-between">
                  <span>Nível de Acesso</span>
                  <span class="text-[10px] text-slate-400 font-mono">🔒 Atribuído</span>
                </label>
                <input type="text" value="{{ $cargoDescricao }}" disabled class="w-full bg-slate-100 border border-slate-200 text-slate-700 rounded-xl py-2.5 px-3.5 text-sm cursor-not-allowed select-none">
              </div>

              <!-- Status -->
              <div class="space-y-1.5">
                <label class="text-xs font-semibold text-slate-600 flex items-center justify-between">
                  <span>Situação Cadastral</span>
                  <span class="text-[10px] text-slate-400 font-mono">🔒 Sistema</span>
                </label>
                <input type="text" value="Ativo / Regular" disabled class="w-full bg-slate-100 border border-slate-200 text-emerald-700 font-semibold rounded-xl py-2.5 px-3.5 text-sm cursor-not-allowed select-none">
              </div>
            </div>
          </div>

          <!-- 2. Dados Cadastrais & Atuação (Editáveis) -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-5">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
              <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-900 border border-blue-200 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                  <path d="m15 5 4 4"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-base font-bold text-slate-900">Dados do Colaborador</h2>
                <p class="text-xs text-slate-500">Mantenha seu nome, polo de atendimento e e-mail sempre atualizados.</p>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
              <!-- Nome Completo -->
              <div class="space-y-1.5 md:col-span-2">
                <label for="nome" class="text-xs font-semibold text-slate-700">Nome Completo <span class="text-rose-500">*</span></label>
                <input type="text" id="nome" name="nome" value="{{ old('nome', $colaborador?->nome ?? $usuario->name) }}" required class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>

              <!-- Cidade de Atuação -->
              <div class="space-y-1.5">
                <label for="cidade" class="text-xs font-semibold text-slate-700">Cidade / Polo de Atuação <span class="text-rose-500">*</span></label>
                <input type="text" id="cidade" name="cidade" placeholder="Ex: Salvador" value="{{ old('cidade', $colaborador?->cidade ?? 'Salvador') }}" required class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>

              <!-- E-mail Corporativo -->
              <div class="space-y-1.5">
                <label for="email" class="text-xs font-semibold text-slate-700">E-mail Corporativo / Login <span class="text-rose-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $colaborador?->email ?? $usuario->email) }}" required class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>
            </div>
          </div>

        @else
          <!-- ========================================================================= -->
          <!-- FORMULÁRIO PARA PACIENTES (NÍVEL 1)                                       -->
          <!-- ========================================================================= -->

          <!-- 1. Identificação Civil & SUS (Inalteráveis) -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
              <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>
                </div>
                <div>
                  <h2 class="text-base font-bold text-slate-900">Identificação Civil & SUS (Inalteráveis)</h2>
                  <p class="text-xs text-slate-500">Dados cadastrais permanentes vinculados ao seu prontuário clínico e registro nacional.</p>
                </div>
              </div>
              <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200/60 w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Campos Bloqueados
              </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
              <!-- CPF -->
              <div class="space-y-1.5">
                <label class="text-xs font-semibold text-slate-600 flex items-center justify-between">
                  <span>CPF (Chave Única)</span>
                  <span class="text-[10px] text-slate-400 font-mono">🔒 Imutável</span>
                </label>
                <input type="text" value="{{ $cpfFormatado }}" disabled class="w-full bg-slate-100 border border-slate-200 text-slate-700 font-mono rounded-xl py-2.5 px-3.5 text-sm cursor-not-allowed select-none">
              </div>

              <!-- Cartão SUS -->
              <div class="space-y-1.5">
                <label class="text-xs font-semibold text-slate-600 flex items-center justify-between">
                  <span>Cartão Nacional do SUS</span>
                  <span class="text-[10px] text-slate-400 font-mono">🔒 Imutável</span>
                </label>
                <input type="text" value="{{ $susFormatado }}" disabled class="w-full bg-slate-100 border border-slate-200 text-slate-700 font-mono rounded-xl py-2.5 px-3.5 text-sm cursor-not-allowed select-none">
              </div>

              <!-- Data de Nascimento -->
              <div class="space-y-1.5">
                <label class="text-xs font-semibold text-slate-600 flex items-center justify-between">
                  <span>Data de Nascimento</span>
                  <span class="text-[10px] text-slate-400 font-mono">🔒 Imutável</span>
                </label>
                <input type="text" value="{{ $paciente?->data_nascimento ? \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') . ($idade ? ' (' . $idade . ' anos)' : '') : 'Não informada' }}" disabled class="w-full bg-slate-100 border border-slate-200 text-slate-700 rounded-xl py-2.5 px-3.5 text-sm cursor-not-allowed select-none">
              </div>

              <!-- Sexo Biológico -->
              <div class="space-y-1.5">
                <label class="text-xs font-semibold text-slate-600 flex items-center justify-between">
                  <span>Sexo Biológico</span>
                  <span class="text-[10px] text-slate-400 font-mono">🔒 Imutável</span>
                </label>
                <input type="text" value="{{ match(strtoupper($paciente?->sexo ?? '')) { 'F' => 'Feminino', 'M' => 'Masculino', 'O' => 'Outro', default => 'Não informado' } }}" disabled class="w-full bg-slate-100 border border-slate-200 text-slate-700 rounded-xl py-2.5 px-3.5 text-sm cursor-not-allowed select-none">
              </div>

              <!-- Nome da Mãe -->
              <div class="space-y-1.5 md:col-span-2">
                <label class="text-xs font-semibold text-slate-600 flex items-center justify-between">
                  <span>Nome Completo da Mãe</span>
                  <span class="text-[10px] text-slate-400 font-mono">🔒 Registro Civil</span>
                </label>
                <input type="text" value="{{ $paciente?->nome_mae ?? 'Não informado' }}" disabled class="w-full bg-slate-100 border border-slate-200 text-slate-700 rounded-xl py-2.5 px-3.5 text-sm cursor-not-allowed select-none">
              </div>
            </div>
          </div>

          <!-- 2. Dados Pessoais & Sociais (Editáveis) -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-5">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
              <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-900 border border-blue-200 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                  <path d="m15 5 4 4"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-base font-bold text-slate-900">Dados Pessoais & Sociais</h2>
                <p class="text-xs text-slate-500">Mantenha seu nome e dados sociodemográficos sempre atualizados.</p>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
              <!-- Nome Completo -->
              <div class="space-y-1.5 md:col-span-2">
                <label for="nome_completo" class="text-xs font-semibold text-slate-700">Nome Completo <span class="text-rose-500">*</span></label>
                <input type="text" id="nome_completo" name="nome_completo" value="{{ old('nome_completo', $paciente?->nome_completo ?? $usuario->name) }}" required class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>

              <!-- Apelido -->
              <div class="space-y-1.5">
                <label for="apelido" class="text-xs font-semibold text-slate-700">Nome Social / Como prefere ser chamado(a)</label>
                <input type="text" id="apelido" name="apelido" placeholder="Ex: Mari, Dani" value="{{ old('apelido', $paciente?->apelido) }}" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>

              <!-- Raça / Cor -->
              <div class="space-y-1.5">
                <label for="raca_cor" class="text-xs font-semibold text-slate-700">Raça / Cor <span class="text-rose-500">*</span></label>
                @php $racaAtual = old('raca_cor', $paciente?->raca_cor ?? ''); @endphp
                <select id="raca_cor" name="raca_cor" required class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all cursor-pointer">
                  <option value="">Selecione uma opção</option>
                  <option value="Branca" {{ in_array(strtolower($racaAtual), ['branca', 'branco']) ? 'selected' : '' }}>Branca</option>
                  <option value="Preta" {{ in_array(strtolower($racaAtual), ['preta', 'preto', 'negra', 'negro']) ? 'selected' : '' }}>Preta</option>
                  <option value="Parda" {{ in_array(strtolower($racaAtual), ['parda', 'pardo']) ? 'selected' : '' }}>Parda</option>
                  <option value="Amarela" {{ in_array(strtolower($racaAtual), ['amarela', 'amarelo']) ? 'selected' : '' }}>Amarela</option>
                  <option value="Indígena" {{ in_array(strtolower($racaAtual), ['indigena', 'indígena']) ? 'selected' : '' }}>Indígena</option>
                  <option value="Não informado" {{ in_array(strtolower($racaAtual), ['nao_informado', 'não informado', 'outro']) ? 'selected' : '' }}>Não informado</option>
                </select>
              </div>

              <!-- Escolaridade -->
              <div class="space-y-1.5 md:col-span-2">
                <label for="escolaridade" class="text-xs font-semibold text-slate-700">Grau de Escolaridade <span class="text-rose-500">*</span></label>
                @php $escAtual = old('escolaridade', $paciente?->escolaridade ?? ''); @endphp
                <select id="escolaridade" name="escolaridade" required class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all cursor-pointer">
                  <option value="">Selecione a escolaridade</option>
                  <option value="Não alfabetizado" {{ str_contains(strtolower($escAtual), 'alfabetizado') ? 'selected' : '' }}>Não alfabetizado</option>
                  <option value="Ensino Fundamental Incompleto" {{ str_contains(strtolower($escAtual), 'fundamental_incompleto') || str_contains(strtolower($escAtual), 'fundamental incompleto') ? 'selected' : '' }}>Ensino Fundamental Incompleto</option>
                  <option value="Ensino Fundamental Completo" {{ str_contains(strtolower($escAtual), 'fundamental_completo') || str_contains(strtolower($escAtual), 'fundamental completo') ? 'selected' : '' }}>Ensino Fundamental Completo</option>
                  <option value="Ensino Médio Incompleto" {{ str_contains(strtolower($escAtual), 'medio_incompleto') || str_contains(strtolower($escAtual), 'médio incompleto') ? 'selected' : '' }}>Ensino Médio Incompleto</option>
                  <option value="Ensino Médio Completo" {{ str_contains(strtolower($escAtual), 'medio_completo') || str_contains(strtolower($escAtual), 'médio completo') ? 'selected' : '' }}>Ensino Médio Completo</option>
                  <option value="Ensino Superior Incompleto" {{ str_contains(strtolower($escAtual), 'superior_incompleto') || str_contains(strtolower($escAtual), 'superior incompleto') ? 'selected' : '' }}>Ensino Superior Incompleto</option>
                  <option value="Ensino Superior Completo" {{ str_contains(strtolower($escAtual), 'superior_completo') || str_contains(strtolower($escAtual), 'superior completo') ? 'selected' : '' }}>Ensino Superior Completo</option>
                  <option value="Pós-graduação" {{ str_contains(strtolower($escAtual), 'pos_graduacao') || str_contains(strtolower($escAtual), 'pós') ? 'selected' : '' }}>Pós-graduação</option>
                </select>
              </div>
            </div>
          </div>

          <!-- 3. Contato (Celular / WhatsApp) -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-5">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
              <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-900 border border-blue-200 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect>
                  <path d="M12 18h.01"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-base font-bold text-slate-900">Contato & Acesso</h2>
                <p class="text-xs text-slate-500">Utilizado para confirmações de 24h e login no portal.</p>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
              <!-- Celular -->
              <div class="space-y-1.5">
                <label for="celular" class="text-xs font-semibold text-slate-700">Celular / WhatsApp <span class="text-rose-500">*</span></label>
                <input type="tel" id="celular" name="celular" placeholder="(00) 00000-0000" maxlength="15" value="{{ old('celular', $telFormatado) }}" required class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all font-mono">
              </div>

              <!-- E-mail -->
              <div class="space-y-1.5">
                <label for="email" class="text-xs font-semibold text-slate-700">E-mail de Login <span class="text-rose-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" required class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>
            </div>
          </div>

          <!-- 4. Endereço Residencial -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-5">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
              <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-900 border border-blue-200 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                  <circle cx="12" cy="10" r="3"></circle>
                </svg>
              </div>
              <div>
                <h2 class="text-base font-bold text-slate-900">Endereço Residencial</h2>
                <p class="text-xs text-slate-500">Informe seu endereço para direcionamento às Unidades Móveis mais próximas.</p>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
              <div class="space-y-1.5">
                <label for="cep" class="text-xs font-semibold text-slate-700 flex items-center justify-between">
                  <span>CEP</span>
                  <span id="cep-loading" class="text-[10px] text-blue-900 font-semibold hidden">Buscando CEP...</span>
                </label>
                <input type="text" id="cep" name="cep" placeholder="00000-000" maxlength="9" value="{{ old('cep', $endereco?->cep) }}" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all font-mono">
              </div>

              <div class="space-y-1.5 md:col-span-2">
                <label for="logradouro" class="text-xs font-semibold text-slate-700">Rua / Avenida / Logradouro</label>
                <input type="text" id="logradouro" name="logradouro" placeholder="Ex: Rua das Flores" value="{{ old('logradouro', $endereco?->logradouro) }}" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>

              <div class="space-y-1.5">
                <label for="numero" class="text-xs font-semibold text-slate-700">Número</label>
                <input type="text" id="numero" name="numero" placeholder="Ex: 123 ou S/N" value="{{ old('numero', $endereco?->numero) }}" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>

              <div class="space-y-1.5">
                <label for="complemento" class="text-xs font-semibold text-slate-700">Complemento (Opcional)</label>
                <input type="text" id="complemento" name="complemento" placeholder="Ex: Apto 42, Bloco B" value="{{ old('complemento', $endereco?->complemento) }}" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>

              <div class="space-y-1.5">
                <label for="bairro" class="text-xs font-semibold text-slate-700">Bairro</label>
                <input type="text" id="bairro" name="bairro" placeholder="Ex: Centro" value="{{ old('bairro', $endereco?->bairro) }}" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>

              <div class="space-y-1.5 md:col-span-2">
                <label for="municipio" class="text-xs font-semibold text-slate-700">Município / Cidade</label>
                <input type="text" id="municipio" name="municipio" placeholder="Ex: Salvador" value="{{ old('municipio', $endereco?->municipio) }}" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>

              <div class="space-y-1.5">
                <label for="uf" class="text-xs font-semibold text-slate-700">UF / Estado</label>
                <input type="text" id="uf" name="uf" placeholder="Ex: BA" maxlength="2" value="{{ old('uf', $endereco?->uf ?? 'BA') }}" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all uppercase font-mono">
              </div>

              <div class="space-y-1.5 md:col-span-3">
                <label for="ponto_referencia" class="text-xs font-semibold text-slate-700">Ponto de Referência (Opcional)</label>
                <input type="text" id="ponto_referencia" name="ponto_referencia" placeholder="Ex: Próximo à Unidade Básica de Saúde" value="{{ old('ponto_referencia', $endereco?->ponto_referencia) }}" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
              </div>
            </div>
          </div>
        @endif

        <!-- ========================================================================= -->
        <!-- SEGURANÇA & ALTERAÇÃO DE SENHA (COMUM A TODOS OS NÍVEIS)                 -->
        <!-- ========================================================================= -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-5">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
              <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-900 border border-blue-200 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 2l-2 2m-1.5 1.5L16 7l-1.5-1.5-1.5 1.5 1.5 1.5-3 3L8 9.5 6.5 11l1.5 1.5-5 5A2 2 0 0 0 3 21h3a2 2 0 0 0 2-2v-1l1.5-1.5L11 18l1.5-1.5-1.5-1.5 3-3 1.5 1.5 1.5-1.5-1.5-1.5 1.5-1.5 2-2Z"></path>
                </svg>
              </div>
              <div>
                <h2 class="text-base font-bold text-slate-900">Segurança da Conta & Senha</h2>
                <p class="text-xs text-slate-500">Deixe os campos em branco caso queira manter sua senha atual inalterada.</p>
              </div>
            </div>
            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-900 bg-blue-50 px-2.5 py-1 rounded-md border border-blue-200/60 w-fit">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              Proteção com Senha Atual
            </span>
          </div>

          <div class="p-3 bg-blue-50/60 border border-blue-100 rounded-xl text-xs text-blue-900 flex items-start gap-2.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-700 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <div>
              <strong>Segurança Reforçada:</strong> Para definir uma nova senha, é <strong>obrigatório informar a sua Senha Atual</strong> para comprovar a titularidade da conta.
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <!-- 1. Senha Atual -->
            <div class="space-y-1.5">
              <label for="current_password" class="text-xs font-semibold text-slate-700">Senha Atual</label>
              <div class="relative">
                <input type="password" id="current_password" name="current_password" placeholder="Digite sua senha atual" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 pl-3.5 pr-10 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
                <button type="button" onclick="togglePasswordVisibility('current_password', 'toggle-current-btn')" id="toggle-current-btn" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer" aria-label="Mostrar/ocultar senha atual">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
            </div>

            <!-- 2. Nova Senha -->
            <div class="space-y-1.5">
              <label for="password" class="text-xs font-semibold text-slate-700">Nova Senha</label>
              <div class="relative">
                <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 pl-3.5 pr-10 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
                <button type="button" onclick="togglePasswordVisibility('password', 'toggle-new-btn')" id="toggle-new-btn" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer" aria-label="Mostrar/ocultar nova senha">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>

              <!-- Indicador de Força -->
              <div id="password-strength-container" class="space-y-1 pt-1 hidden">
                <div class="flex items-center justify-between text-[11px]">
                  <span class="text-slate-500">Força da senha:</span>
                  <span id="password-strength-label" class="font-semibold text-slate-600">-</span>
                </div>
                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                  <div id="password-strength-bar" class="h-full w-0 transition-all duration-300 rounded-full bg-slate-300"></div>
                </div>
              </div>
            </div>

            <!-- 3. Confirmar Nova Senha -->
            <div class="space-y-1.5">
              <label for="password_confirmation" class="text-xs font-semibold text-slate-700">Confirmar Nova Senha</label>
              <div class="relative">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repita a nova senha" class="w-full bg-white border border-slate-300 rounded-xl py-2.5 pl-3.5 pr-10 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10 transition-all">
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'toggle-confirm-btn')" id="toggle-confirm-btn" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer" aria-label="Mostrar/ocultar confirmação de senha">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <p id="password-match-feedback" class="text-[11px] text-slate-400 hidden"></p>
            </div>
          </div>
        </div>

        <!-- ========================================================================= -->
        <!-- BARRA DE AÇÃO / SALVAR ALTERAÇÕES                                        -->
        <!-- ========================================================================= -->
        <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2">
          <a href="{{ $rotaRetorno }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 text-sm font-semibold transition-all shadow-xs">
            Cancelar / Voltar
          </a>

          <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow-md transition-all cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
              <polyline points="17 21 17 13 7 13 7 21"></polyline>
              <polyline points="7 3 7 8 15 8"></polyline>
            </svg>
            Salvar Alterações
          </button>
        </div>
      </form>

    </main>

  </div>

  <!-- Scripts para Máscaras, Busca de CEP (ViaCEP) e Segurança de Senha -->
  <script>
    // Função para Exibir / Ocultar Senha (Olho 👁️)
    function togglePasswordVisibility(inputId, btnId) {
      const input = document.getElementById(inputId);
      const btn = document.getElementById(btnId);
      if (!input || !btn) return;

      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';

      // Alterna ícone de olho aberto / cortado
      btn.innerHTML = isPassword
        ? `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
    }

    document.addEventListener('DOMContentLoaded', function() {
      // 1. Máscara de Telefone/Celular (se presente)
      const celularInput = document.getElementById('celular');
      if (celularInput) {
        celularInput.addEventListener('input', function(e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 11) value = value.substring(0, 11);
          
          if (value.length > 10) {
            value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
          } else if (value.length > 6) {
            value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
          } else if (value.length > 2) {
            value = value.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
          } else if (value.length > 0) {
            value = value.replace(/^(\d*)$/, '($1');
          }
          e.target.value = value;
        });
      }

      // 2. Máscara de CEP e Busca no ViaCEP (se presente)
      const cepInput = document.getElementById('cep');
      const cepLoading = document.getElementById('cep-loading');
      const logradouroInput = document.getElementById('logradouro');
      const bairroInput = document.getElementById('bairro');
      const municipioInput = document.getElementById('municipio');
      const ufInput = document.getElementById('uf');

      if (cepInput) {
        cepInput.addEventListener('input', function(e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 8) value = value.substring(0, 8);
          
          if (value.length > 5) {
            value = value.replace(/^(\d{5})(\d{1,3})$/, '$1-$2');
          }
          e.target.value = value;

          // Busca automática ao digitar os 8 dígitos
          const rawCep = value.replace(/\D/g, '');
          if (rawCep.length === 8) {
            if (cepLoading) cepLoading.classList.remove('hidden');
            
            fetch(`https://viacep.com.br/ws/${rawCep}/json/`)
              .then(res => res.json())
              .then(data => {
                if (!data.erro) {
                  if (logradouroInput && !logradouroInput.value) logradouroInput.value = data.logradouro || '';
                  if (bairroInput && !bairroInput.value) bairroInput.value = data.bairro || '';
                  if (municipioInput) municipioInput.value = data.localidade || '';
                  if (ufInput) ufInput.value = data.uf || '';
                }
              })
              .catch(() => {})
              .finally(() => {
                if (cepLoading) cepLoading.classList.add('hidden');
              });
          }
        });
      }

      // 3. Indicador de Força de Senha e Comparador em Tempo Real
      const passwordInput = document.getElementById('password');
      const passwordConfirmInput = document.getElementById('password_confirmation');
      const strengthContainer = document.getElementById('password-strength-container');
      const strengthBar = document.getElementById('password-strength-bar');
      const strengthLabel = document.getElementById('password-strength-label');
      const matchFeedback = document.getElementById('password-match-feedback');

      function calculateStrength(pwd) {
        let score = 0;
        if (!pwd) return 0;
        if (pwd.length >= 8) score += 25;
        if (pwd.length >= 10) score += 15;
        if (/[A-Z]/.test(pwd)) score += 20;
        if (/[0-9]/.test(pwd)) score += 20;
        if (/[^A-Za-z0-9]/.test(pwd)) score += 20;
        return Math.min(100, score);
      }

      if (passwordInput) {
        passwordInput.addEventListener('input', function() {
          const val = passwordInput.value;
          if (val.length > 0) {
            strengthContainer.classList.remove('hidden');
            const strength = calculateStrength(val);
            strengthBar.style.width = strength + '%';

            if (strength < 40) {
              strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-rose-500';
              strengthLabel.innerText = 'Fraca (mínimo 8 caracteres e números)';
              strengthLabel.className = 'font-semibold text-rose-600 text-[11px]';
            } else if (strength < 75) {
              strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-amber-500';
              strengthLabel.innerText = 'Média (boa)';
              strengthLabel.className = 'font-semibold text-amber-600 text-[11px]';
            } else {
              strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-emerald-500';
              strengthLabel.innerText = 'Forte (excelente)';
              strengthLabel.className = 'font-semibold text-emerald-600 text-[11px]';
            }
          } else {
            strengthContainer.classList.add('hidden');
          }

          checkMatch();
        });
      }

      function checkMatch() {
        if (!passwordConfirmInput || !passwordInput) return;
        const pwd = passwordInput.value;
        const confirm = passwordConfirmInput.value;

        if (confirm.length > 0) {
          matchFeedback.classList.remove('hidden');
          if (pwd === confirm) {
            matchFeedback.innerText = '✓ As senhas conferem';
            matchFeedback.className = 'text-[11px] text-emerald-600 font-medium';
          } else {
            matchFeedback.innerText = '✗ As senhas não coincidem';
            matchFeedback.className = 'text-[11px] text-rose-600 font-medium';
          }
        } else {
          matchFeedback.classList.add('hidden');
        }
      }

      if (passwordConfirmInput) {
        passwordConfirmInput.addEventListener('input', checkMatch);
      }
    });
  </script>
</body>

</html>
