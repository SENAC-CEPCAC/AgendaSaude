<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Colaborador</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <script src="./js/auth.js"></script>
    <script>validarAcesso(3);</script>

    


    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
              mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'monospace'],
            },
            spacing: {
              '4.5': '1.125rem',
            }
          }
        }
      }
    </script>
  </head>
  <body class="bg-[#f8fafc]">
  <div id="app-root" class="min-h-screen bg-[#f8fafc] text-slate-800 font-sans antialiased">
      @include('components.sidebar')

      <main id="main-content" class="min-h-screen flex flex-col p-6 md:p-8">
        <header id="top-bar" class="h-16 bg-white border-b border-slate-100 px-4 md:px-6 flex items-center justify-between sticky top-0 z-20 shadow-sm rounded-xl mb-6">
          <div class="flex items-center gap-3">
            <button id="mobile-menu-toggle" class="p-2 -ml-2 text-slate-500 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-colors cursor-pointer">
              <i data-lucide="menu" class="w-5 h-5"></i>
            </button>

            <div id="breadcrumb" class="flex items-center gap-2 text-xs text-slate-400 font-medium">
              <span>Portal Gestão</span>
              <span>/</span>
              <span class="text-slate-600 font-semibold">Colaborador</span>
            </div>
          </div>

          <div id="top-bar-actions" class="flex items-center gap-4">
            <button id="notification-button" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-lg relative transition-colors cursor-pointer">
              <i data-lucide="bell" class="w-5 h-5"></i>
              <span id="notification-indicator" class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full"></span>
            </button>

            <div id="user-profile" class="flex items-center gap-3 pl-4 border-l border-slate-100">
              <div id="user-avatar" class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-600 text-xs shadow-inner">
                AD
              </div>
              <div id="user-info" class="hidden sm:block text-left">
                <p id="user-name" class="text-xs font-bold text-slate-700">Dr. Marcos G.</p>
                <p id="user-role" class="text-[10px] text-slate-400 font-semibold leading-none mt-0.5">Gestor Geral</p>
              </div>
            </div>
          </div>
        </header>

        <div class="max-w-7xl w-full mx-auto space-y-6">
          <h1 class="text-2xl font-bold uppercase tracking-wide text-[#0f172a]">Colaborador</h1>

          <div class="bg-white rounded-xl border border-slate-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
            <div class="relative w-full md:w-96 flex items-center">
              <i data-lucide="search" class="absolute left-4 text-slate-400 w-5 h-5 pointer-events-none"></i>
              <input type="text" id="searchInput" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-12 pr-4 text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white transition-all" placeholder="Buscar paciente ou prontuário...">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto justify-end">
              <select class="bg-white border border-slate-200 text-slate-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-sky-500 transition-all cursor-pointer">
                <option value="">Filtrar Colaborador</option>
              </select>
              <button class="bg-[#00478f] hover:bg-[#00366d] text-white text-xs font-bold uppercase tracking-wider flex items-center gap-2 px-5 py-3.5 rounded-xl shadow-md shadow-blue-900/10 transition-all cursor-pointer" onclick="cadastrarColaborador()">
                <i data-lucide="calendar-check" class="w-4 h-4"></i> Cadastrar
              </button>
            </div>
          </div>

          <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                  <th class="py-4 px-6 w-[25%]">Colaborador</th>
                  <th class="py-4 px-6 w-[20%]">Matricula</th>
                  <th class="py-4 px-6 w-[25%]">Email</th>
                  <th class="py-4 px-6 w-[30%] text-center">Ações</th>
                </tr>
              </thead>
              <tbody id="colaboradoresTable" class="divide-y divide-slate-100 text-sm text-slate-600">
                <!-- Inserido dinamicamente via JS -->
              </tbody>
            </table>
          </div>

          <div class="flex items-center justify-between text-sm text-slate-500 pt-2">
            <div id="paginationInfo">Mostrando 1 a 6 de 45 pacientes</div>
            <div class="flex items-center gap-2">
              <button class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-600 transition-all cursor-pointer" onclick="mudarPagina('prev')">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
              </button>
              <button class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-600 transition-all cursor-pointer" onclick="mudarPagina('next')">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    
  </body>
</html>
