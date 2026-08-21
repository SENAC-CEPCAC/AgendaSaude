// Lista usuários para LOGAR
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

// Carrega do localStorage, garante os usuários padrões e salva de volta
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

document.getElementById('loginForm')?.addEventListener('submit', (e) => {
  e.preventDefault();
  const userIn = document.getElementById('username').value.toLowerCase().trim();
  const passIn = document.getElementById('password').value;

  const lista = obterUsuarios();
  const userFound = lista.find(u => u.username.toLowerCase() === userIn && u.password === passIn);

  if (!userFound) {
    document.getElementById('errorMessage').textContent = 'Usuário ou senha inválidos!';
    return;
  }

  // Conta desativada
  if (userFound.ativo === false) {
    document.getElementById('errorMessage').textContent = 'Acesso desativado! Fale com o administrador.';
    return;
  }

  localStorage.setItem('userLogado', JSON.stringify({
    username: userFound.username,
    nivel: userFound.nivel
  }));

  if (userFound.nivel === 1) window.location.href = 'n1_pagina.html';
  if (userFound.nivel === 2) window.location.href = 'paciente.html';
  if (userFound.nivel === 3) window.location.href = 'colaborador.html';
  if (userFound.nivel >= 4) window.location.href = 'acesso_restrito.html';
});