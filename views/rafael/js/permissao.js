 
  const usuarios = [
    { username: "operador", password: "123", nivel: 1 },
    { username: "analista", password: "123", nivel: 2 },
    { username: "admin",    password: "123", nivel: 3 }
  ];

  document.getElementById('loginForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const userIn = document.getElementById('username').value;
    const passIn = document.getElementById('password').value;

    const userFound = usuarios.find(u => u.username === userIn && u.password === passIn);

    if (userFound) {

      localStorage.setItem('userLogado', JSON.stringify({
        username: userFound.username,
        nivel: userFound.nivel
      }));
      
      if (userFound.nivel === 1) window.location.href = 'n1_pagina.html';
      if (userFound.nivel === 2) window.location.href = 'paciente.html';
      if (userFound.nivel === 3) window.location.href = 'colaborador.html';
    } else {
      document.getElementById('errorMessage').textContent = 'Usuário ou senha inválidos!';
    }
  });