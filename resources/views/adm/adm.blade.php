<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de acesso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen overflow-x-hidden bg-slate-50 text-slate-800 antialiased">
    @include('sidebar.sidebar_n4')
    <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-slate-900/40 opacity-0 transition-opacity duration-300"></div>
    <button id="mobile-menu-toggle" type="button" class="fixed left-3 top-3 z-[60] flex items-center justify-center rounded-lg bg-blue-600 p-2 text-white shadow-sm transition hover:bg-blue-800 sm:left-5 sm:top-5" aria-controls="sidebar" aria-expanded="false" aria-label="Abrir menu">
        <i data-lucide="menu" class="h-4 w-4"></i>
    </button>
 
    <main class="mx-auto w-full max-w-5xl px-4 pb-8 pt-24 sm:px-5 sm:pt-24 md:px-0 md:pt-12">
        <h1 class="mb-5 text-lg font-bold pt-10 uppercase tracking-wide text-slate-900 sm:text-xl">Gestão de acesso</h1>

        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <section class="mb-5 flex flex-col items-center justify-between gap-4 rounded-xl border border-slate-100 bg-white p-4 shadow-sm sm:p-5 md:flex-row">
            <form method="GET" action="{{ route('adm.adm') }}" class="relative w-full md:w-80">
                <i data-lucide="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                <input name="busca" value="{{ $busca }}" type="search" placeholder="Pesquisar..." class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-10 pr-4 text-xs outline-none transition focus:border-blue-500 focus:bg-white">
            </form>
            <div class="flex w-full justify-end gap-3 md:w-auto">
                
                <button type="button" id="open-cadastro-modal" class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-800 px-5 py-3 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm transition  md:w-auto">
                    <i data-lucide="calendar-plus" class="h-4 w-4"></i> Cadastrar
                </button>
            </div>
        </section>

        <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-190 border-collapse text-left">
                    <thead class="bg-slate-50 text-[10px] font-bold uppercase tracking-wide text-slate-700">
                        <tr class="border-b border-slate-100">
                            <th class="px-5 py-4">Colaborador</th>
                            <th class="px-5 py-4">Permissão</th>
                            <th class="px-5 py-4">Email</th>
                            <th class="px-5 py-4">Cidade</th>
                            <th class="px-5 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-xs text-slate-600">
                        @forelse ($colaboradores as $colaborador)
                            <tr class="transition hover:bg-slate-50/90">
                                <td class="px-5 py-4 font-bold text-slate-800">{{ $colaborador->nome }}</td>
                                <td class="px-5 py-4">N{{ $colaborador->permissao }}</td>
                                <td class="px-5 py-4">{{ $colaborador->email }}</td>
                                <td class="px-5 py-4">{{ $colaborador->cidade }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex justify-center gap-2">
                                        <form method="POST" action="{{ route('adm.status', $colaborador) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-lg {{ $colaborador->ativo ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700' }} px-3 py-2 text-[9px] font-bold uppercase text-white" type="submit">
                                                {{ $colaborador->ativo ? 'Desativar' : 'Ativar' }}
                                            </button>
                                        </form>
                                        <button type="button" data-edit-id="{{ $colaborador->id }}" data-edit-name="{{ $colaborador->nome }}" data-edit-permissao="{{ $colaborador->permissao }}" class="flex items-center gap-1 rounded-lg bg-blue-600 px-3 py-2 text-[9px] font-bold uppercase text-white hover:bg-blue-800">
                                            <i data-lucide="pencil" class="h-3 w-3"></i> Alterar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-sm text-slate-400">Nenhum colaborador encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="mt-6 flex flex-col gap-3 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <span>Mostrando {{ $colaboradores->firstItem() ?? 0 }} a {{ $colaboradores->lastItem() ?? 0 }} de {{ $colaboradores->total() }} colaboradores</span>
            <div class="max-w-full overflow-x-auto">{{ $colaboradores->links() }}</div>
        </div>
    </main>
    <div id="cadastro-modal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto bg-slate-900/45 px-4 py-6 sm:py-8" role="dialog" aria-modal="true" aria-labelledby="cadastro-modal-title">
        <div class="my-auto max-h-[calc(100vh-3rem)] w-full max-w-md overflow-y-auto rounded-xl bg-white p-4 shadow-2xl sm:max-h-[calc(100vh-4rem)] sm:p-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <h2 id="cadastro-modal-title" class="text-lg font-bold text-slate-800">Cadastrar Nivel de Acesso</h2>
                <button type="button" id="close-cadastro-modal" class="text-2xl leading-none text-slate-400 transition hover:text-slate-700" aria-label="Fechar">&times;</button>
            </div>

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-rose-100 bg-rose-50 px-3 py-2 text-xs text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('adm.colaboradores.store') }}" class="mt-4 space-y-3">
                @csrf
                <label class="block text-xs font-semibold text-slate-600">Nome Completo
                    <input name="nome" placeholder="Cactus Tech" value="{{ old('nome') }}" required class="mt-1.5 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 text-sm outline-none focus:border-blue-500 focus:bg-white">
                </label>
                <label class="block text-xs font-semibold text-slate-600">Email
                    <input name="email" placeholder="cactus@sesc.ba" type="email" value="{{ old('email') }}" required class="mt-1.5 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 text-sm outline-none focus:border-blue-500 focus:bg-white">
                </label>
                <label class="block text-xs font-semibold text-slate-600">Matrícula
                    <input name="matricula" placeholder="12345678"value="{{ old('matricula') }}" required maxlength="100" class="mt-1.5 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 text-sm outline-none focus:border-blue-500 focus:bg-white">
                </label>
                <label class="block text-xs font-semibold text-slate-600">Cidade
                    <input name="cidade" placeholder="Salvador" value="{{ old('cidade') }}" required maxlength="255" class="mt-1.5 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 text-sm outline-none focus:border-blue-500 focus:bg-white">
                </label>
                <label class="block text-xs font-semibold text-slate-600">Senha (minimo: 8 digitos)
                    <input name="password" placeholder="********" type="password" required minlength="8" class="mt-1.5 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 text-sm outline-none focus:border-blue-500 focus:bg-white">
                </label>
                <label class="block text-xs font-semibold text-slate-600">Permissão
                    <select name="permissao" required class="mt-1.5 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 text-sm outline-none focus:border-blue-500 focus:bg-white">
                        <!-- <option value="1" @selected(old('permissao') == 1)>N1 - Paciente</option> -->
                        <option value="2" @selected(old('permissao') == 2)>N2 - Colaborador</option>
                        <option value="3" @selected(old('permissao') == 3)>N3 - Medico</option>
                        <option value="4" @selected(old('permissao') == 4)>N4 - Gestor</option>
                    </select>
                </label>
                <div class="flex justify-end gap-2 border-t border-slate-200 pt-3">
                    <button type="button" id="cancel-cadastro-modal" class="rounded-lg bg-slate-100 px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-200">Cancelar</button>
                    <button type="submit" class="rounded-lg bg-blue-800 px-4 py-2.5 text-xs font-bold text-white hover:bg-blue-900">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    <div id="edicao-modal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto bg-slate-900/45 px-4 py-6 sm:py-8" role="dialog" aria-modal="true" aria-labelledby="edicao-modal-title">
        <div class="my-auto w-full max-w-md rounded-xl bg-white p-4 shadow-2xl sm:p-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <h2 id="edicao-modal-title" class="text-lg font-bold text-slate-800">Alterar Permissão</h2>
                <button type="button" id="close-edicao-modal" class="text-2xl leading-none text-slate-400 transition hover:text-slate-700" aria-label="Fechar">&times;</button>
            </div>
            <p id="edicao-colaborador" class="mt-4 text-sm text-slate-600"></p>
            <form id="edicao-form" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PATCH')
                <label class="block text-xs font-semibold text-slate-600">Permissão
                    <select id="edicao-permissao" name="permissao" required class="mt-1.5 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 text-sm outline-none focus:border-blue-500 focus:bg-white">
                        <!-- <option value="1">N1 - Paciente</option> -->
                        <option value="2">N2 - Colaborador</option>
                        <option value="3">N3 - Médico</option>
                        <option value="4">N4 - Gestor</option>
                    </select>
                </label>
                <div class="flex justify-end gap-2 border-t border-slate-200 pt-3">
                    <button type="button" id="cancel-edicao-modal" class="rounded-lg bg-slate-100 px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-200">Cancelar</button>
                    <button type="submit" class="rounded-lg bg-blue-800 px-4 py-2.5 text-xs font-bold text-white hover:bg-blue-900">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    <script>lucide.createIcons();</script>
    <script>
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        const setSidebarOpen = (open) => {
            sidebar.classList.toggle('-translate-x-full', !open);
            sidebar.classList.toggle('translate-x-0', open);
            sidebarOverlay.classList.toggle('hidden', !open);
            sidebarOverlay.classList.toggle('opacity-100', open);
            mobileMenuToggle.classList.toggle('hidden', open);
            mobileMenuToggle.setAttribute('aria-expanded', String(open));
            mobileMenuToggle.setAttribute('aria-label', open ? 'Recolher menu' : 'Abrir menu');
        };

        mobileMenuToggle.addEventListener('click', () => setSidebarOpen(!sidebar.classList.contains('translate-x-0')));
        mobileMenuClose.addEventListener('click', () => setSidebarOpen(false));
        sidebarOverlay.addEventListener('click', () => setSidebarOpen(false));

        const cadastroModal = document.getElementById('cadastro-modal');
        const toggleCadastroModal = (open) => {
            cadastroModal.classList.toggle('hidden', !open);
            cadastroModal.classList.toggle('flex', open);
        };

        document.getElementById('open-cadastro-modal').addEventListener('click', () => toggleCadastroModal(true));
        document.getElementById('close-cadastro-modal').addEventListener('click', () => toggleCadastroModal(false));
        document.getElementById('cancel-cadastro-modal').addEventListener('click', () => toggleCadastroModal(false));
        cadastroModal.addEventListener('click', (event) => {
            if (event.target === cadastroModal) toggleCadastroModal(false);
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') toggleCadastroModal(false);
        });

        @if ($errors->any())
            toggleCadastroModal(true);
        @endif

        const edicaoModal = document.getElementById('edicao-modal');
        const edicaoForm = document.getElementById('edicao-form');
        const toggleEdicaoModal = (open) => {
            edicaoModal.classList.toggle('hidden', !open);
            edicaoModal.classList.toggle('flex', open);
        };

        document.querySelectorAll('[data-edit-id]').forEach((button) => {
            button.addEventListener('click', () => {
                edicaoForm.action = `{{ url('/adm') }}/${button.dataset.editId}`;
                document.getElementById('edicao-colaborador').textContent = `Colaborador: ${button.dataset.editName}`;
                document.getElementById('edicao-permissao').value = button.dataset.editPermissao;
                toggleEdicaoModal(true);
            });
        });
        document.getElementById('close-edicao-modal').addEventListener('click', () => toggleEdicaoModal(false));
        document.getElementById('cancel-edicao-modal').addEventListener('click', () => toggleEdicaoModal(false));
        edicaoModal.addEventListener('click', (event) => {
            if (event.target === edicaoModal) toggleEdicaoModal(false);
        });
    </script>
</body>
</html>
