
function onDomReady(callback) {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', callback);
  } else {
    callback();
  }
}

function formatarNomeUsuario(username) {
  if (!username) return '';
  return username
    .split(/\s+/)
    .filter(Boolean)
    .map((parte) => parte.charAt(0).toUpperCase() + parte.slice(1).toLowerCase())
    .join(' ');
}

function gerarInicialUsuario(username) {
  if (!username) return '';
  const partes = username.split(/\s+/).filter(Boolean);
  if (partes.length === 0) return '';
  if (partes.length === 1) return partes[0].slice(0, 2).toUpperCase();
  return (partes[0][0] + partes[partes.length - 1][0]).toUpperCase();
}

function getLabelNivel(nivel) {
  switch (nivel) {
    case 4:
      return 'Administrador';
    case 3:
      return 'Colaborador';
    case 2:
      return 'Paciente';
    case 1:
    default:
      return 'Usuário';
  }
}

function atualizarUsuarioLogado(usuario) {
  if (!usuario || !usuario.username) return;

  onDomReady(() => {
    const nomeFormatado = formatarNomeUsuario(usuario.username);
    const papel = getLabelNivel(usuario.nivel);
    const avatar = document.getElementById('user-avatar');
    const userNameEl = document.getElementById('user-name');
    const userRoleEl = document.getElementById('user-role');

    if (avatar) {
      avatar.textContent = gerarInicialUsuario(usuario.username);
    }
    if (userNameEl) {
      userNameEl.textContent = nomeFormatado;
    }
    if (userRoleEl) {
      userRoleEl.textContent = papel;
    }
  });
}

function validarAcesso(nivelMinimoRequerido) {
  const sessao = localStorage.getItem('userLogado');
  
  if (!sessao) {
    alert('Acesso negado! Faça login para continuar.');
    window.location.href = 'index.html';
    return;
  }

  const usuario = JSON.parse(sessao);
  atualizarUsuarioLogado(usuario);
  
  if (usuario.nivel < nivelMinimoRequerido) {
    alert(`Acesso Restrito! Seu nível (N${usuario.nivel}) não tem permissão para esta página.`);
    
    switch (usuario.nivel) {
      case 4:
        window.location.href = 'acesso_restrito.html';
        break;
      case 3:
        window.location.href = 'colaborador.html';
        break;
      case 2:
        window.location.href = 'paciente.html';
        break;
      case 1:
      default:
        window.location.href = 'index.html'; 
        break;
    }
  }
}

function logout() {
  localStorage.removeItem('userLogado');
  window.location.href = 'index.html';
}