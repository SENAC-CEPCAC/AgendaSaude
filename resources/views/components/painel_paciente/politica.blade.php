@vite(['resources/css/app.css'])

<!-- Inicio Modal Politicas de Privacidade -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
    
    <!-- Overlay de fundo escurecido -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    <!-- Container do Modal -->
    <div class="relative w-full max-w-3xl max-h-[90vh] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden z-10 border border-slate-100">
        
        <!-- Cabeçalho do Modal (Fixo) -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-slate-50/80">
            <div class="flex items-center gap-2">
                <div class="p-1.5 bg-teal-100 rounded-lg text-teal-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 leading-tight">Política de Privacidade</h2>
                    <p class="text-xs text-slate-500">Sesc Bahia · Agenda Saúde</p>
                </div>
            </div>

            <!-- Botão fechar -->
            <button type="button" class="text-slate-400 hover:text-slate-600 hover:bg-slate-200/60 rounded-lg p-1.5 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Conteúdo do Documento (Rolável) -->
        <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6 text-slate-600 text-sm leading-relaxed">
            
            <header class="border-b border-slate-100 pb-4">
                <p class="text-xs uppercase font-semibold tracking-wider text-teal-700">Carreta de Saúde da Mulher</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900">Termos e Política de Privacidade</h1>
                <p class="mt-1 text-xs text-slate-500">Versão 1.0 · Última atualização em {{ now()->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y') }}</p>
            </header>

            <div class="prose prose-slate max-w-none prose-h2:text-base prose-h2:font-bold prose-h2:text-slate-900 prose-h2:mt-6 prose-h3:font-semibold prose-h3:text-slate-800 prose-a:text-teal-700">
                
                <p>
                    Esta Política de Privacidade descreve como o <strong>Serviço Social do Comércio — Administração
                    Regional na Bahia (Sesc Bahia)</strong> coleta, utiliza, armazena, compartilha e protege os dados
                    pessoais das usuárias e usuários do aplicativo <strong>Agenda Saúde</strong>, utilizado para o
                    agendamento de exames de mama (mamografia) e de colo do útero (citologia/Papanicolau) realizados na
                    carreta itinerante de saúde da mulher do Sesc Bahia.
                </p>
                <p>
                    Este documento foi elaborado com base na <strong>Lei nº 13.709/2018 — Lei Geral de Proteção de Dados
                    Pessoais (LGPD)</strong> e observa as diretrizes da <strong>Agência Nacional de Proteção de Dados
                    (ANPD)</strong>.
                </p>

                <h2>1. Quem é o controlador dos seus dados</h2>
                <p>
                    O Sesc Bahia é o <strong>agente de tratamento (controlador)</strong> dos dados pessoais coletados
                    por meio do Agenda Saúde, nos termos do art. 5º, VI, da LGPD.
                </p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>Razão social:</strong> Serviço Social do Comércio — Administração Regional na Bahia</li>
                    <li><strong>Encarregado pelo Tratamento de Dados Pessoais (DPO):</strong> [nome do encarregado a ser designado, art. 41 da LGPD]</li>
                    <li><strong>Canal de contato do Encarregado:</strong> [e-mail/telefone institucional]</li>
                </ul>

                <h2>2. Quais dados coletamos</h2>
                <p>Para viabilizar o agendamento e a realização dos exames, podemos coletar:</p>
                
                <h3>2.1 Dados pessoais comuns</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Nome completo, CPF e data de nascimento;</li>
                    <li>Telefone e e-mail para contato e confirmação de agendamento;</li>
                    <li>Endereço ou localidade de referência;</li>
                    <li>Dados de acesso ao aplicativo (login, data e hora de uso).</li>
                </ul>

                <h3>2.2 Dados pessoais sensíveis (art. 5º, II, da LGPD)</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Dados sobre saúde, como tipo de exame agendado, histórico de agendamentos e informações clínicas necessárias à triagem;</li>
                    <li>Dados constantes de avaliações e pesquisas de satisfação (NPS).</li>
                </ul>
                <p>
                    Por se tratar de <strong>dado sensível de saúde</strong>, esse tipo de informação recebe tratamento
                    diferenciado e reforçado de segurança, conforme o art. 11 da LGPD, e <strong>não é utilizado para
                    fins comerciais ou compartilhado com terceiros com objetivo de vantagem econômica</strong>.
                </p>

                <h2>3. Para que usamos seus dados (finalidade e base legal)</h2>
                <div class="overflow-x-auto my-4">
                    <table class="w-full text-left border-collapse border border-slate-200 text-xs">
                        <thead>
                            <tr class="bg-slate-100 text-slate-700">
                                <th class="p-2 border border-slate-200">Finalidade</th>
                                <th class="p-2 border border-slate-200">Base legal (LGPD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-200">
                                <td class="p-2 border border-slate-200">Agendar, confirmar, remarcar ou cancelar exames na carreta</td>
                                <td class="p-2 border border-slate-200">Execução de política pública / tutela da saúde (art. 11, II, "f")</td>
                            </tr>
                            <tr class="border-b border-slate-200">
                                <td class="p-2 border border-slate-200">Enviar lembretes e notificações sobre o agendamento</td>
                                <td class="p-2 border border-slate-200">Consentimento (art. 7º, I)</td>
                            </tr>
                            <tr class="border-b border-slate-200">
                                <td class="p-2 border border-slate-200">Registrar avaliação pós-atendimento (NPS)</td>
                                <td class="p-2 border border-slate-200">Consentimento (art. 7º, I)</td>
                            </tr>
                            <tr>
                                <td class="p-2 border border-slate-200">Cumprir obrigações legais e regulatórias em saúde</td>
                                <td class="p-2 border border-slate-200">Obrigação legal/regulatória (art. 7º, II)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2>4. Com quem compartilhamos seus dados</h2>
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>SYDLE ONE:</strong> plataforma de gestão para integração dos fluxos de agendamento;</li>
                    <li><strong>Equipe técnica e de saúde da carreta:</strong> acesso restrito à execução dos exames;</li>
                    <li><strong>Autoridades de saúde pública:</strong> quando exigido por lei.</li>
                </ul>

                <h2>5. Segurança da informação</h2>
                <p>
                    Adotamos medidas técnicas e administrativas aptas a proteger os dados pessoais de acessos não
                    autorizados e de situações acidentais ou ilícitas.
                </p>

                <div class="mt-6 rounded-xl bg-amber-50 p-4 border border-amber-200 text-xs text-amber-900">
                    <strong>Aviso:</strong> Este documento passa por revisões periódicas para garantir a máxima conformidade com as exigências da LGPD e diretrizes da ANPD.
                </div>
            </div>
        </div>

        <!-- Rodapé do Modal com Ação / Botão Aceito (Fixo) -->
        <div class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50 border-t border-slate-200">
            <a href="{{ route('acesso.cadastro') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-semibold text-sm rounded-lg shadow-sm hover:shadow transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Aceito
            </a>
        </div>

    </div>
</div>
<!-- Fim Modal Politicas de Privacidade -->

<!-- Lucide Icon Library & Initialization -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();

    // Mobile Sidebar Toggle Logic
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function openSidebar() {
        if (sidebar && sidebarOverlay) {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            setTimeout(() => {
                sidebarOverlay.classList.add('opacity-100');
            }, 10);
        }
    }

    function closeSidebar() {
        if (sidebar && sidebarOverlay) {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.remove('opacity-100');
            setTimeout(() => {
                sidebarOverlay.classList.add('hidden');
            }, 300);
        }
    }

    if (mobileMenuToggle && mobileMenuClose && sidebar && sidebarOverlay) {
        mobileMenuToggle.addEventListener('click', openSidebar);
        mobileMenuClose.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);
    }
</script>