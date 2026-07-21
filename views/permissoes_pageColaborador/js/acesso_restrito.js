lucide.createIcons();

// Dados padrão iniciais
const padraoColaboradores = [
  { nome: "Gestor",   permissao: "N4", email: "gestor@email.com",    ativo: true },
  { nome: "Gabriel",  permissao: "N3", email: "gabriel@email.com",  ativo: true },
  { nome: "Mateus",   permissao: "N3", email: "mateus@email.com",   ativo: true },
  { nome: "William",  permissao: "N1", email: "william@email.com",  ativo: true },
  { nome: "Rafael",   permissao: "N1", email: "rafael@email.com",   ativo: true },
  { nome: "Isabela",  permissao: "N2", email: "isabela@email.com",  ativo: true },
  { nome: "Vinicius", permissao: "N2", email: "vinicius@email.com", ativo: true }
];

// Sincronização inicial entre "colaboradores" e "listaUsuarios"
function inicializarDados() {
  if (!localStorage.getItem('listaUsuarios')) {
    const listaIniciada = padraoColaboradores.map(c => ({
      username: c.nome.toLowerCase(),
      password: "123",
      nivel: parseInt(c.permissao.replace("N", "")),
      ativo: c.ativo
    }));
    localStorage.setItem('listaUsuarios', JSON.stringify(listaIniciada));
  }

  if (!localStorage.getItem('colaboradoresData')) {
    localStorage.setItem('colaboradoresData', JSON.stringify(padraoColaboradores));
  }
}

inicializarDados();

function obterColaboradores() {
  return JSON.parse(localStorage.getItem('colaboradoresData')) || [];
}

function salvarColaboradores(data) {
  localStorage.setItem('colaboradoresData', JSON.stringify(data));
}

function obterUsuariosSistema() {
  return JSON.parse(localStorage.getItem('listaUsuarios')) || [];
}

function salvarUsuariosSistema(data) {
  localStorage.setItem('listaUsuarios', JSON.stringify(data));
}

// Renderização da tabela
function renderTable(data) {
  const tbody = document.getElementById('colaboradoresTable');
  if (!tbody) return;
  tbody.innerHTML = '';

  data.forEach((colab, index) => {
    const isAtivo = colab.ativo !== false;
    const tr = document.createElement('tr');
    tr.className = `hover:bg-slate-50/50 transition-colors ${!isAtivo ? 'bg-slate-100 opacity-60' : ''}`;
    tr.innerHTML = `
      <td class="py-4 px-6 font-bold text-slate-800">${colab.nome}</td>
      <td class="py-4 px-6 text-slate-500 font-semibold">${colab.permissao}</td>
      <td class="py-4 px-6 text-slate-500">${colab.email}</td>
      <td class="py-4 px-6">
        <div class="flex items-center justify-center gap-2">
          <button onclick="toggleStatus(${index})" class="${isAtivo ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700'} text-white text-[10px] font-bold uppercase tracking-wider px-3 py-2 rounded-lg shadow-sm transition-all cursor-pointer">
            ${isAtivo ? 'Desativar' : 'Ativar'}
          </button>
          <button onclick="editar(${index})" class="bg-[#00478f] hover:bg-[#00366d] text-white text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5 px-3 py-2 rounded-lg shadow-sm transition-all cursor-pointer">
            <i data-lucide="edit" class="w-3.5 h-3.5"></i> Alterar
          </button>
        </div>
      </td>
    `;
    tbody.appendChild(tr);
  });

  lucide.createIcons();
}

// Ativar/Desativar usuário
function toggleStatus(id) {
  const colaboradores = obterColaboradores();
  const usuarios = obterUsuariosSistema();

  colaboradores[id].ativo = !colaboradores[id].ativo;
  
  const idxUser = usuarios.findIndex(u => u.username.toLowerCase() === colaboradores[id].nome.toLowerCase());
  if (idxUser !== -1) {
    usuarios[idxUser].ativo = colaboradores[id].ativo;
  }

  salvarColaboradores(colaboradores);
  salvarUsuariosSistema(usuarios);
  renderTable(colaboradores);
}

function fecharModal() {
  document.getElementById('cadastrarModal')?.remove();
}

// Alterar Nível (N1, N2, N3, N4)
function editar(id) {
  const colaboradores = obterColaboradores();
  const usuarios = obterUsuariosSistema();
  const colab = colaboradores[id];

  if (!colab) return;

  fecharModal();

  const modal = document.createElement('div');
  modal.id = 'cadastrarModal';
  modal.className = 'fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
  modal.innerHTML = `
    <div class="bg-white rounded-xl shadow-2xl border border-slate-100 max-w-md w-full p-6 space-y-4">
      <div class="flex justify-between items-center border-b pb-3">
        <h3 class="text-lg font-bold text-slate-800">Alterar Permissão</h3>
        <button type="button" onclick="fecharModal()" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
      </div>
      <form id="formAlterarPermissao" class="space-y-3">
        <div>
          <label class="block text-xs font-semibold text-slate-600 mb-1">Permissão</label>
          <select id="novoNivel" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm">
            <option value="1" ${colab.permissao === 'N1' ? 'selected' : ''}>N1 - Paciente</option>
            <option value="2" ${colab.permissao === 'N2' ? 'selected' : ''}>N2 - Operador</option>
            <option value="3" ${colab.permissao === 'N3' ? 'selected' : ''}>N3 - Colaborador</option>
            <option value="4" ${colab.permissao === 'N4' ? 'selected' : ''}>N4 - Administrador</option>
          </select>
        </div>
        <div class="flex justify-end gap-2 pt-3 border-t">
          <button type="button" onclick="fecharModal()" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200">Cancelar</button>
          <button type="submit" class="px-4 py-2 bg-[#00478f] text-white text-xs font-bold rounded-lg hover:bg-[#00366d]">Salvar</button>
        </div>
      </form>
    </div>
  `;

  document.body.appendChild(modal);

  document.getElementById('formAlterarPermissao').addEventListener('submit', (e) => {
    e.preventDefault();
    const nivel = parseInt(document.getElementById('novoNivel').value);

    colab.permissao = `N${nivel}`;

    const idxUser = usuarios.findIndex(u => u.username.toLowerCase() === colab.nome.toLowerCase());
    if (idxUser !== -1) {
      usuarios[idxUser].nivel = nivel;
    }

    salvarColaboradores(colaboradores);
    salvarUsuariosSistema(usuarios);
    renderTable(colaboradores);
    fecharModal();
  });
}

// Modal de Cadastro
function cadastrarColaborador() {
  document.getElementById('cadastrarModal')?.remove();

  const modal = document.createElement('div');
  modal.id = 'cadastrarModal';
  modal.className = 'fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
  modal.innerHTML = `
    <div class="bg-white rounded-xl shadow-2xl border border-slate-100 max-w-md w-full p-6 space-y-4">
      <div class="flex justify-between items-center border-b pb-3">
        <h3 class="text-lg font-bold text-slate-800">Cadastrar Novo Colaborador</h3>
        <button onclick="document.getElementById('cadastrarModal').remove()" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
      </div>
      <form id="formNovoColaborador" class="space-y-3">
        <div>
          <label class="block text-xs font-semibold text-slate-600 mb-1">Nome / Usuário</label>
          <input type="text" id="novoNome" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm" required>
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
          <input type="email" id="novoEmail" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm" required>
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-600 mb-1">Senha</label>
          <input type="password" id="novaSenha" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm" required>
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-600 mb-1">Permissão</label>
          <select id="novoNivel" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm">
            <option value="1">N1 - Paciente</option>
            <option value="2">N2 - Operador</option>
            <option value="3">N3 - Colaborador</option>
            <option value="4">N4 - Administrador</option>
          </select>
        </div>
        <div class="flex justify-end gap-2 pt-3 border-t">
          <button type="button" onclick="document.getElementById('cadastrarModal').remove()" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200">Cancelar</button>
          <button type="submit" class="px-4 py-2 bg-[#00478f] text-white text-xs font-bold rounded-lg hover:bg-[#00366d]">Salvar</button>
        </div>
      </form>
    </div>
  `;

  document.body.appendChild(modal);

  document.getElementById('formNovoColaborador').addEventListener('submit', (e) => {
    e.preventDefault();
    const nome = document.getElementById('novoNome').value.trim();
    const email = document.getElementById('novoEmail').value.trim();
    const senha = document.getElementById('novaSenha').value;
    const nivel = parseInt(document.getElementById('novoNivel').value);

    const colaboradores = obterColaboradores();
    const usuarios = obterUsuariosSistema();

    // Adiciona colaborador na tabela
    colaboradores.push({
      nome: nome,
      permissao: `N${nivel}`,
      email: email,
      ativo: true
    });

    // Adiciona credencial no login
    usuarios.push({
      username: nome.toLowerCase(),
      password: senha,
      nivel: nivel,
      ativo: true
    });

    salvarColaboradores(colaboradores);
    salvarUsuariosSistema(usuarios);
    renderTable(colaboradores);

    document.getElementById('cadastrarModal').remove();
  });
}

// Filtro de Busca
document.getElementById('searchInput')?.addEventListener('input', function(e) {
  const query = e.target.value.toLowerCase();
  const colaboradores = obterColaboradores();
  const filtered = colaboradores.filter(c => 
    c.nome.toLowerCase().includes(query) || 
    c.email.toLowerCase().includes(query)
  );
  renderTable(filtered);
});

// Renderização Inicial
renderTable(obterColaboradores());