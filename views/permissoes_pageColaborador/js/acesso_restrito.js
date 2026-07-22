import { createModalController } from './modal.js';

const usuariosIniciais = [
  { username: "gestor",   password: "123", nivel: 4, ativo: true },
  { username: "gabriel",  password: "123", nivel: 3, ativo: true },
  { username: "mateus",   password: "123", nivel: 3, ativo: true },
  { username: "william",  password: "123", nivel: 1, ativo: true },
  { username: "rafael",   password: "123", nivel: 1, ativo: true },
  { username: "isabela",  password: "123", nivel: 2, ativo: true },
  { username: "vinicius", password: "123", nivel: 2, ativo: true }
];

function garantirUsuariosPadrao(listaAtual = []) {
  const lista = Array.isArray(listaAtual) ? listaAtual : [];
  const usuariosMap = new Map();

  lista.forEach((usuario) => {
    if (usuario?.username) {
      usuariosMap.set(usuario.username.toLowerCase(), {
        ...usuario,
        username: usuario.username
      });
    }
  });

  usuariosIniciais.forEach((usuarioPadrao) => {
    const chave = usuarioPadrao.username.toLowerCase();
    const existente = usuariosMap.get(chave);

    usuariosMap.set(chave, {
      ...(existente || {}),
      username: existente?.username || usuarioPadrao.username,
      password: usuarioPadrao.password,
      nivel: usuarioPadrao.nivel,
      ativo: usuarioPadrao.ativo
    });
  });

  return Array.from(usuariosMap.values());
}

function obterUsuarios() {
  const local = localStorage.getItem('listaUsuarios');
  let lista = [];

  if (local) {
    try {
      lista = JSON.parse(local);
    } catch (error) {
      lista = [];
    }
  }

  const usuariosNormalizados = garantirUsuariosPadrao(lista);
  const precisaSalvar = JSON.stringify(usuariosNormalizados) !== local;

  if (precisaSalvar) {
    localStorage.setItem('listaUsuarios', JSON.stringify(usuariosNormalizados));
  }

  return usuariosNormalizados;
}

function obterUsuarioLogado() {
  const local = localStorage.getItem('userLogado');
  if (!local) return null;
  try {
    return JSON.parse(local);
  } catch {
    return null;
  }
}

function redirecionarPorNivel(nivel) {
  if (nivel === 1) return window.location.href = 'n1_pagina.html';
  if (nivel === 2) return window.location.href = 'paciente.html';
  if (nivel === 3) return window.location.href = 'colaborador.html';
  return window.location.href = 'acesso_restrito.html';
}

function verificarAcessoPagina() {
  const usuario = obterUsuarioLogado();
  const pagina = window.location.pathname.split('/').pop() || 'index.html';

  if (!usuario) {
    if (pagina !== 'index.html' && pagina !== 'login.html') {
      window.location.href = 'index.html';
    }
    return;
  }

  if (pagina === 'index.html' || pagina === 'login.html') {
    redirecionarPorNivel(usuario.nivel);
    return;
  }

  const permissoesPorPagina = {
    'acesso_restrito.html': 4,
    'colaborador.html': 3,
    'paciente.html': 2
  };

  const nivelMinimo = permissoesPorPagina[pagina];
  if (nivelMinimo && usuario.nivel < nivelMinimo) {
    redirecionarPorNivel(usuario.nivel);
  }
}

function configurarLogin() {
  const form = document.getElementById('loginForm');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const userIn = document.getElementById('username').value.toLowerCase().trim();
    const passIn = document.getElementById('password').value;

    const lista = obterUsuarios();
    const userFound = lista.find(u => u.username.toLowerCase() === userIn && u.password === passIn);

    if (!userFound) {
      document.getElementById('errorMessage').textContent = 'Usuário ou senha inválidos!';
      return;
    }

    if (userFound.ativo === false) {
      document.getElementById('errorMessage').textContent = 'Acesso desativado! Fale com o administrador.';
      return;
    }

    localStorage.setItem('userLogado', JSON.stringify({
      username: userFound.username,
      nivel: userFound.nivel
    }));

    redirecionarPorNivel(userFound.nivel);
  });
}

verificarAcessoPagina();
configurarLogin();

window.lucide?.createIcons?.();

// Dados padrão iniciais
const padraoColaboradores = [
  { nome: "Gestor",   permissao: "N4", email: "gestor@email.com",   cidade: "Salvador",         ativo: true },
  { nome: "Gabriel",  permissao: "N3", email: "gabriel@email.com",  cidade: "Camaçari",         ativo: true },
  { nome: "Mateus",   permissao: "N3", email: "mateus@email.com",   cidade: "Feira de Santana", ativo: true },
  { nome: "William",  permissao: "N1", email: "william@email.com",  cidade: "Lençois",          ativo: true },
  { nome: "Rafael",   permissao: "N1", email: "rafael@email.com",   cidade: "Feira de Santana", ativo: true },
  { nome: "Isabela",  permissao: "N2", email: "isabela@email.com",  cidade: "Camaçari",         ativo: true },
  { nome: "Vinicius", permissao: "N2", email: "vinicius@email.com", cidade: "Salvador",         ativo: true }
];

// Sincronização inicial entre "colaboradores" e "listaUsuarios"
function inicializarDados() {
  const colaboradoresExistentes = JSON.parse(localStorage.getItem('colaboradoresData'));
  const usuariosExistentes = JSON.parse(localStorage.getItem('listaUsuarios'));

  if (!usuariosExistentes) {
    const listaIniciada = padraoColaboradores.map(c => ({
      username: c.nome.toLowerCase(),
      password: "123",
      nivel: parseInt(c.permissao.replace("N", "")),
      ativo: c.ativo
    }));
    localStorage.setItem('listaUsuarios', JSON.stringify(listaIniciada));
  } else {
    const atualizados = padraoColaboradores.map(c => {
      const usuario = usuariosExistentes.find(u => u.username === c.nome.toLowerCase());
      return {
        username: c.nome.toLowerCase(),
        password: usuario?.password || "123",
        nivel: parseInt(c.permissao.replace("N", "")),
        ativo: usuario?.ativo ?? c.ativo
      };
    });
    localStorage.setItem('listaUsuarios', JSON.stringify(atualizados));
  }

  if (!colaboradoresExistentes) {
    localStorage.setItem('colaboradoresData', JSON.stringify(padraoColaboradores));
  } else {
    const atualizados = padraoColaboradores.map(c => {
      const colab = colaboradoresExistentes.find(item => item.nome === c.nome);
      return {
        ...c,
        ativo: colab?.ativo ?? c.ativo
      };
    });
    localStorage.setItem('colaboradoresData', JSON.stringify(atualizados));
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
      <td class="py-4 px-6 text-slate-500">${colab.cidade || ''}</td>
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

const { fecharModal, editar, cadastrarColaborador } = createModalController({
  obterColaboradores,
  obterUsuariosSistema,
  salvarColaboradores,
  salvarUsuariosSistema,
  renderTable
});

window.toggleStatus = toggleStatus;
window.fecharModal = fecharModal;
window.editar = editar;
window.cadastrarColaborador = cadastrarColaborador;

// Filtro de Busca
const colaboradoresTable = document.getElementById('colaboradoresTable');
if (colaboradoresTable) {
  const filterFieldEl = document.getElementById('filterField');
  if (filterFieldEl) {
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
      const query = e.target.value.toLowerCase();
      const field = filterFieldEl.value || 'colaborador';
      const colaboradores = obterColaboradores();
      const filtered = colaboradores.filter(c => {
        switch (field) {
          case 'colaborador':
            return c.nome.toLowerCase().includes(query);
          case 'permissao':
            return c.permissao.toLowerCase().includes(query);
          case 'email':
            return c.email.toLowerCase().includes(query);
          case 'cidade':
            return (c.cidade || '').toLowerCase().includes(query);
          case 'acoes':
            return (`${c.ativo !== false ? 'desativar' : 'ativar'} alterar`).includes(query);
          default:
            return c.nome.toLowerCase().includes(query) ||
                   c.permissao.toLowerCase().includes(query) ||
                   c.email.toLowerCase().includes(query) ||
                   (c.cidade || '').toLowerCase().includes(query);
        }
      });
      renderTable(filtered);
    });
  }

  // Renderização Inicial
  renderTable(obterColaboradores());
}
