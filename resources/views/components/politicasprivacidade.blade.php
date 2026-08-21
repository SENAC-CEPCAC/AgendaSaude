@vite(['resources/css/app.css'])


  <!--Inicio Confirmado-->


  <!-- Overlay -->
  <div class="fixed inset-0 bg-black/50"></div>

  <!-- Modal -->
  <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-md bg-[#f7f8fc] rounded-xl shadow-2xl px-6 py-5">
    <!-- Botão fechar -->
    <div class="flex justify-end">
      <button class="text-gray-800 hover:text-gray-600 text-lg leading-none">
        &times;
      </button>
    </div>

    <hr class="border-gray-300 mt-3">

    <!-- Conteúdo confirmado -->
    <div class="flex items-center justify-center gap-2 py-6">
      <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
      <span class="text-green-600 font-semibold tracking-wide text-sm">
        
        
        <!-- Inicio Politicas Privacidade -->




        @extends('layouts.app')

@section('title', 'Política de Privacidade — Agenda Saúde')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-3xl px-4">

        <header class="mb-10 border-b border-slate-200 pb-6">
            <p class="text-sm font-medium text-teal-700">Sesc Bahia · Carreta de Saúde da Mulher</p>
            <h1 class="mt-1 text-3xl font-bold text-slate-900">Política de Privacidade</h1>
            <p class="mt-2 text-sm text-slate-500">Versão 1.0 · Última atualização em {{ now()->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y') }}</p>
        </header>

        <div class="prose prose-slate max-w-none prose-h2:text-xl prose-h2:font-semibold prose-h2:text-slate-900 prose-h2:mt-10 prose-h3:font-semibold prose-a:text-teal-700">

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
                (ANPD)</strong>, autoridade responsável pela fiscalização da proteção de dados pessoais no Brasil.
            </p>

            <h2>1. Quem é o controlador dos seus dados</h2>
            <p>
                O Sesc Bahia é o <strong>agente de tratamento (controlador)</strong> dos dados pessoais coletados
                por meio do Agenda Saúde, nos termos do art. 5º, VI, da LGPD.
            </p>
            <ul>
                <li><strong>Razão social:</strong> Serviço Social do Comércio — Administração Regional na Bahia</li>
                <li><strong>Encarregado pelo Tratamento de Dados Pessoais (DPO):</strong> [nome do encarregado a ser designado, art. 41 da LGPD]</li>
                <li><strong>Canal de contato do Encarregado:</strong> [e-mail/telefone institucional]</li>
            </ul>
            <p class="text-sm italic text-slate-500">
                Observação: os campos entre colchetes devem ser preenchidos com os dados reais do Sesc Bahia antes
                da publicação deste documento.
            </p>

            <h2>2. Quais dados coletamos</h2>
            <p>Para viabilizar o agendamento e a realização dos exames, podemos coletar:</p>
            <h3>2.1 Dados pessoais comuns</h3>
            <ul>
                <li>Nome completo, CPF e data de nascimento;</li>
                <li>Telefone e e-mail para contato e confirmação de agendamento;</li>
                <li>Endereço ou localidade de referência, para associar a usuária ao ponto de parada da carreta;</li>
                <li>Dados de acesso ao aplicativo (login, data e hora de uso).</li>
            </ul>
            <h3>2.2 Dados pessoais sensíveis (art. 5º, II, da LGPD)</h3>
            <ul>
                <li>Dados sobre saúde, como tipo de exame agendado (mamografia e/ou citologia), histórico de
                    agendamentos, comparecimento e, quando aplicável, informações clínicas necessárias à triagem
                    pré-exame;</li>
                <li>Dados constantes de avaliações e pesquisas de satisfação (NPS) preenchidas após o atendimento.</li>
            </ul>
            <p>
                Por se tratar de <strong>dado sensível de saúde</strong>, esse tipo de informação recebe tratamento
                diferenciado e reforçado de segurança, conforme o art. 11 da LGPD, e <strong>não é utilizado para
                fins comerciais ou compartilhado com terceiros com objetivo de vantagem econômica</strong>, o que é
                vedado pelo art. 11, §4º, da LGPD.
            </p>

            <h2>3. Para que usamos seus dados (finalidade e base legal)</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-slate-300">
                        <th class="py-2 pr-4">Finalidade</th>
                        <th class="py-2">Base legal (LGPD)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-100">
                        <td class="py-2 pr-4">Agendar, confirmar, remarcar ou cancelar exames na carreta</td>
                        <td class="py-2">Execução de política pública / tutela da saúde (art. 11, II, "f")</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-2 pr-4">Enviar lembretes e notificações sobre o agendamento</td>
                        <td class="py-2">Consentimento (art. 7º, I e art. 11, I) / legítimo interesse não sensível</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-2 pr-4">Registrar avaliação pós-atendimento e pesquisa de satisfação (NPS)</td>
                        <td class="py-2">Consentimento (art. 7º, I)</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-2 pr-4">Gerar estatísticas de cobertura e planejamento de rotas da carreta</td>
                        <td class="py-2">Estudo por órgão de pesquisa, preferencialmente anonimizado (art. 7º, IV)</td>
                    </tr>
                    <tr>
                        <td class="py-2 pr-4">Cumprir obrigações legais e regulatórias em saúde</td>
                        <td class="py-2">Cumprimento de obrigação legal/regulatória (art. 7º, II)</td>
                    </tr>
                </tbody>
            </table>

            <h2>4. Com quem compartilhamos seus dados</h2>
            <ul>
                <li><strong>SYDLE ONE:</strong> plataforma de gestão utilizada para integração e processamento dos
                    fluxos de agendamento, sob contrato que exige da operadora as mesmas obrigações de
                    confidencialidade e segurança do Sesc Bahia (operador de dados, art. 5º, VII);</li>
                <li><strong>Equipe técnica e de saúde da carreta:</strong> acesso restrito e necessário à execução
                    do exame agendado;</li>
                <li><strong>Autoridades de saúde pública</strong>, quando exigido por lei ou determinação regulatória;</li>
                <li>
                    <strong>Não vendemos, alugamos ou comercializamos</strong> seus dados pessoais, especialmente os
                    dados de saúde, a terceiros para fins de publicidade ou vantagem econômica.
                </li>
            </ul>

            <h2>5. Por quanto tempo guardamos seus dados</h2>
            <p>
                Os dados são mantidos pelo período necessário ao cumprimento das finalidades descritas nesta
                Política, observados os prazos legais e regulatórios aplicáveis a registros de saúde e agendamentos,
                findo o qual serão eliminados ou anonimizados, ressalvadas as hipóteses do art. 16 da LGPD (cumprimento
                de obrigação legal, estudo por órgão de pesquisa, transferência a terceiro ou uso exclusivo do
                controlador, vedado o acesso por terceiro).
            </p>

            <h2>6. Seus direitos como titular de dados</h2>
            <p>Nos termos do art. 18 da LGPD, você pode, mediante solicitação ao Encarregado, a qualquer momento:</p>
            <ul>
                <li>Confirmar a existência de tratamento dos seus dados;</li>
                <li>Acessar os dados que temos sobre você;</li>
                <li>Corrigir dados incompletos, inexatos ou desatualizados;</li>
                <li>Solicitar anonimização, bloqueio ou eliminação de dados desnecessários ou tratados em desconformidade com a lei;</li>
                <li>Solicitar a portabilidade dos seus dados a outro fornecedor de serviço;</li>
                <li>Solicitar a eliminação dos dados tratados com base no seu consentimento;</li>
                <li>Obter informação sobre entidades públicas e privadas com as quais compartilhamos seus dados;</li>
                <li>Revogar o consentimento a qualquer momento, sem afetar a licitude do tratamento realizado anteriormente;</li>
                <li>Solicitar revisão de decisões tomadas unicamente com base em tratamento automatizado, quando aplicável.</li>
            </ul>
            <p>
                As solicitações podem ser feitas por meio do canal de contato do Encarregado indicado na seção 1, e
                serão respondidas dentro dos prazos definidos pela ANPD.
            </p>

            <h2>7. Segurança da informação</h2>
            <p>
                Adotamos medidas técnicas e administrativas aptas a proteger os dados pessoais de acessos não
                autorizados e de situações acidentais ou ilícitas de destruição, perda, alteração, comunicação ou
                qualquer forma de tratamento inadequado ou ilícito (art. 46 da LGPD), incluindo controle de acesso por
                perfil, criptografia de dados sensíveis em trânsito e em repouso, e registro de acessos aos dados de
                saúde. Em caso de incidente de segurança que possa acarretar risco ou dano relevante às usuárias, o
                Sesc Bahia comunicará a ANPD e as titulares afetadas nos prazos regulamentares aplicáveis.
            </p>

            <h2>8. Uso por menores de idade</h2>
            <p>
                O agendamento de exames destinados a adolescentes menores de 18 anos, quando clinicamente indicado,
                somente é realizado com o consentimento específico e em destaque de ao menos um dos pais ou do
                responsável legal, nos termos do art. 14 da LGPD.
            </p>

            <h2>9. Cookies e tecnologias de rastreamento</h2>
            <p>
                O uso de cookies pelo Agenda Saúde é tratado em documento específico — consulte a nossa
                <a href="{{ route('legal.cookies') }}">Política de Cookies</a>.
            </p>

            <h2>10. Alterações desta política</h2>
            <p>
                Esta Política pode ser atualizada para refletir mudanças legais, regulatórias (incluindo novas
                resoluções da ANPD) ou operacionais. A versão vigente estará sempre disponível nesta página, com a
                data da última atualização indicada no cabeçalho.
            </p>

            <h2>11. Fale com a gente</h2>
            <p>
                Dúvidas, solicitações ou reclamações sobre o tratamento dos seus dados pessoais podem ser
                encaminhadas ao Encarregado pelo Tratamento de Dados Pessoais do Sesc Bahia, pelos canais indicados
                na seção 1 desta Política.
            </p>

            <p class="mt-10 rounded-lg bg-amber-50 p-4 text-sm text-amber-900">
                <strong>Aviso:</strong> este texto é um modelo de referência elaborado a partir da LGPD e da agenda
                regulatória vigente da ANPD, mas não substitui a análise de um(a) advogado(a) especializado(a) em
                proteção de dados e saúde. Recomenda-se revisão jurídica antes da publicação oficial, especialmente
                quanto às hipóteses de base legal aplicadas ao contexto específico do Sesc Bahia e à integração com
                a SYDLE ONE.
            </p>
        </div>
    </div>
</div>
@endsection




<!-- Fim Politicas Privacidade -->



      </span>
    </div>

    <hr class="border-gray-300">
  </div>



  <!--Final Confirmado-->

  </main>

  </div>
  </div>

  <!-- Lucide Icon Library & Initialization -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    // Initialize Lucide icons on load
    lucide.createIcons();

    // Mobile Sidebar Toggle Logic
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function openSidebar() {
      sidebar.classList.remove('-translate-x-full');
      sidebarOverlay.classList.remove('hidden');
      setTimeout(() => {
        sidebarOverlay.classList.add('opacity-100');
      }, 10);
    }

    function closeSidebar() {
      sidebar.classList.add('-translate-x-full');
      sidebarOverlay.classList.remove('opacity-100');
      setTimeout(() => {
        sidebarOverlay.classList.add('hidden');
      }, 300);
    }

    if (mobileMenuToggle && mobileMenuClose && sidebar && sidebarOverlay) {
      mobileMenuToggle.addEventListener('click', openSidebar);
      mobileMenuClose.addEventListener('click', closeSidebar);
      sidebarOverlay.addEventListener('click', closeSidebar);
    }
  </script>



