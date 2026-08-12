/* Módulo de fluxo de agendamento
   - Mantém HTML das 3 etapas
   - Injeta conteúdo no main
   - Valida campos obrigatórios antes de avançar
   - Gerencia botão Continuar / Confirmar
   - Permite voltar com o botão de voltar (seta)
*/

const etapasHtml = {
  1: `
    <section class="flex flex-col gap-sm">
      <h2 class="font-h2 text-h2 text-on-background">Escolha a Especialidade</h2>
      <p class="font-body-sm text-body-sm text-on-surface-variant mb-unit">Selecione o tipo de atendimento que você precisa.</p>

      <div class="mb-md">
        <select data-chave="especialidade" class="w-full border rounded p-3 obrigatorio" aria-label="Especialidade">
          <option value="">-- Selecione a especialidade --</option>
          <option value="clinica">Clínica Geral</option>
          <option value="ginecologia">Ginecologia</option>
          <option value="pediatria">Pediatria</option>
        </select>
      </div>
    </section>

    <section class="flex flex-col gap-sm">
      <div class="flex items-center justify-between mb-unit">
        <h2 class="font-h2 text-h2 text-on-background">Unidade Móvel Próxima</h2>
        <button class="p-2 text-primary hover:bg-primary-fixed rounded-full transition-colors" type="button" aria-label="Usar localização">
          <span class="material-symbols-outlined text-[20px]">my_location</span>
        </button>
      </div>

      <div class="flex flex-col gap-gutter">
        <label class="cursor-pointer group relative">
          <input class="peer sr-only obrigatorio" name="unidade" type="radio" value="móvel-centro" />
          <div class="bg-primary-fixed border-2 border-primary rounded-lg p-md flex gap-gutter items-center">
            <div class="flex-1">
              <h3 class="font-h3 text-h3">Unidade Móvel Centro</h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Praça da República, s/n - Centro</p>
            </div>
            <div class="w-6 h-6 rounded-full border-2 border-primary flex items-center justify-center">
              <div class="w-3 h-3 rounded-full bg-primary"></div>
            </div>
          </div>
        </label>

        <label class="cursor-pointer group relative">
          <input class="peer sr-only obrigatorio" name="unidade" type="radio" value="zona-sul" />
          <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-md flex gap-gutter items-center">
            <div class="flex-1">
              <h3 class="font-h3 text-h3">Unidade Zona Sul</h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Av. das Nações, 1500</p>
            </div>
            <div class="w-6 h-6 rounded-full border-2 border-outline-variant flex items-center justify-center">
              <div class="w-3 h-3 rounded-full bg-transparent"></div>
            </div>
          </div>
        </label>
      </div>
    </section>
  `,

  2: `
    <section class="flex flex-col gap-sm">
      <h2 class="font-h2 text-h2 text-on-background">Escolha a Data</h2>
      <p class="font-body-sm text-body-sm text-on-surface-variant mb-unit">Selecione a data e horário desejado.</p>

      <label class="flex flex-col gap-xs">
        <span class="font-label-md">Data</span>
        <input data-chave="data" type="date" class="p-3 border rounded obrigatorio" />
      </label>

      <label class="flex flex-col gap-xs mt-sm">
        <span class="font-label-md">Horário</span>
        <input data-chave="horario" type="time" class="p-3 border rounded obrigatorio" />
      </label>
    </section>
  `,

  3: `
    <section class="flex flex-col gap-sm">
      <h2 class="font-h2 text-h2 text-on-background">Confirmação e Documentos</h2>
      <p class="font-body-sm text-body-sm text-on-surface-variant mb-unit">Revise as informações e envie um documento, se necessário.</p>

      <div class="flex flex-col gap-sm">
        <div class="flex justify-between items-center">
          <span class="font-body-md">Especialidade</span>
          <span id="resumo-especialidade" class="font-body-md text-on-surface-variant">—</span>
        </div>

        <div class="flex justify-between items-center">
          <span class="font-body-md">Unidade</span>
          <span id="resumo-unidade" class="font-body-md text-on-surface-variant">—</span>
        </div>

        <label class="flex flex-col gap-xs mt-sm">
          <span class="font-label-md">Documento (opcional)</span>
          <input data-chave="documento" type="file" accept="image/*,.pdf" class="p-3 border rounded" />
        </label>
      </div>
    </section>
  `
};

let passoAtual = 1;
const dadosAgendamento = {};

function atualizarStepper(passo) {
  const texto = document.getElementById('texto-passo');
  const titulo = document.getElementById('titulo-passo');
  const barra = document.getElementById('barra-progresso');

  if (texto) texto.textContent = `Passo ${passo} de 3`;

  const titulos = {1: '1. Seleção', 2: '2. Data', 3: '3. Confirmação'};
  if (titulo) titulo.textContent = titulos[passo] || '';

  if (barra) {
    const largura = `${(passo / 3) * 100}%`;
    barra.style.width = largura;
  }
}

function validarEtapa(passo) {
  const container = document.getElementById('etapas-container');
  if (!container) return false;

  const obrigatorios = container.querySelectorAll('.obrigatorio');
  let valido = true;

  obrigatorios.forEach(el => {
    // reset estilos
    el.classList.remove('border-error');

    if (el.type === 'radio' || el.type === 'checkbox') {
      const name = el.name;
      const marcado = container.querySelector(`[name="${name}"]:checked`);
      if (!marcado) {
        valido = false;
        // marcar primeiro elemento visualmente
        el.closest('label')?.classList.add('border-error');
      }
    } else {
      const valor = el.value?.trim();
      if (!valor) {
        valido = false;
        el.classList.add('border-error');
      }
    }
  });

  return valido;
}

function salvarDados(passo) {
  const container = document.getElementById('etapas-container');
  if (!container) return;

  const campos = container.querySelectorAll('[data-chave]');
  campos.forEach(c => {
    const chave = c.getAttribute('data-chave');
    if (!chave) return;
    if (c.type === 'file') {
      dadosAgendamento[chave] = c.files && c.files[0] ? c.files[0].name : '';
    } else {
      dadosAgendamento[chave] = c.value;
    }
  });

  // campos especiais: radio grupo 'unidade'
  const unidade = container.querySelector('[name="unidade"]:checked');
  if (unidade) dadosAgendamento['unidade'] = unidade.value;

  // atualizar resumo na etapa 3
  const resumoEsp = document.getElementById('resumo-especialidade');
  const resumoUni = document.getElementById('resumo-unidade');
  if (resumoEsp) resumoEsp.textContent = dadosAgendamento['especialidade'] || '—';
  if (resumoUni) resumoUni.textContent = dadosAgendamento['unidade'] || '—';
}

function atualizarBotao() {
  const botao = document.getElementById('btn-continuar');
  if (!botao) return;

  if (passoAtual < 3) {
    botao.textContent = 'Continuar';
    botao.dataset.acao = 'continuar';
  } else {
    botao.textContent = 'Confirmar Agendamento';
    botao.dataset.acao = 'confirmar';
  }
}

function renderizarEtapa(passo) {
  const container = document.getElementById('etapas-container');
  if (!container) return;

  container.innerHTML = etapasHtml[passo] || '';
  atualizarStepper(passo);
  atualizarBotao();

  // preencher valores salvos se existirem
  Object.keys(dadosAgendamento).forEach(chave => {
    const el = container.querySelector(`[data-chave="${chave}"]`);
    if (el) {
      if (el.type === 'file') return;
      el.value = dadosAgendamento[chave] || '';
    }
  });

  // se tiver unidade salva, marcar rádio correspondente
  if (dadosAgendamento['unidade']) {
    const radio = container.querySelector(`[name="unidade"][value="${dadosAgendamento['unidade']}"]`);
    if (radio) radio.checked = true;
  }
}

function mostrarErroValidacao() {
  // implementação simples: foco no primeiro campo inválido
  const container = document.getElementById('etapas-container');
  const invalido = container.querySelector('.obrigatorio:not([value=""]):not([value="undefined"])');
  // fallback: alert
  alert('Por favor, preencha os campos obrigatórios antes de continuar.');
}

function confirmarAgendamento() {
  // ação final (substituir por chamada real ao backend quando disponível)
  console.log('Dados do agendamento:', dadosAgendamento);
  alert('Agendamento confirmado!');
}

function inicializarFluxo() {
  const btnContinuar = document.getElementById('btn-continuar');
  const btnVoltar = document.getElementById('btn-voltar');

  if (btnContinuar) {
    btnContinuar.addEventListener('click', () => {
      if (btnContinuar.dataset.acao === 'continuar') {
        const valido = validarEtapa(passoAtual);
        if (!valido) { mostrarErroValidacao(); return; }
        salvarDados(passoAtual);
        passoAtual = Math.min(3, passoAtual + 1);
        renderizarEtapa(passoAtual);
      } else {
        // confirmar
        const valido = validarEtapa(passoAtual);
        if (!valido) { mostrarErroValidacao(); return; }
        salvarDados(passoAtual);
        confirmarAgendamento();
      }
    });
  }

  if (btnVoltar) {
    btnVoltar.addEventListener('click', () => {
      if (passoAtual > 1) {
        passoAtual -= 1;
        renderizarEtapa(passoAtual);
      } else {
        // opcional: navegar para página anterior do app
        window.history.back();
      }
    });
  }

  renderizarEtapa(passoAtual);
}

document.addEventListener('DOMContentLoaded', inicializarFluxo);
