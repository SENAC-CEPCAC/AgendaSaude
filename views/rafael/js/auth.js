
function validarAcesso(nivelMinimoRequerido) {
  const sessao = localStorage.getItem('userLogado');
  
  if (!sessao) {
    alert('Acesso negado! Faça login para continuar.');
    window.location.href = 'index.html';
    return;
  }

  const usuario = JSON.parse(sessao);
  
  if (usuario.nivel < nivelMinimoRequerido) {
    alert(`Acesso Restrito! Seu nível (N${usuario.nivel}) não tem permissão para esta página.`);
    
    switch (usuario.nivel) {
      case 3:
        window.location.href = 'colaborador.html';
        break;
      case 2:
        window.location.href = 'paciente.html';
        break;
      case 1:
      default:
        // Ajuste aqui se a página do Nível 1 tiver outro nome
        window.location.href = 'index.html'; 
        break;
    }
  }
}

function logout() {
  localStorage.removeItem('userLogado');
  window.location.href = 'index.html';
}