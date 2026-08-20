<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body {
      font-family: Arial;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #f0f2f5;
      margin: 0;
    }

    .card {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      width: 300px;
    }

    h2 {
      margin-top: 0;
      color: #333;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }

    button:hover {
      background: #0056b3;
    }

    .error {
      color: red;
      font-size: 14px;
      margin-top: 10px;
      text-align: center;
    }
  </style>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>

  <div class="card">
    <h2 class="text-2xl font-bold" >AGENDA SAUDE</h2>
    <br>
    <form>
      <h6 class="email text-xs">E-mail</h6>
      <input type="text" id="username" placeholder="Usuário" required />
      <h6 class="text-xs">Senha</h6>
      <input type="password" id="password" placeholder="Senha" required />
      <h6 class="ml-37 text-xs esqueci">
        <a href="{{ route('recuperacao.recuperacao') }}">Esqueci a senha</a>
      </h6>
      <br>
      <button type="submit">Entrar</button>
    </form>
    <div id="errorMessage" class="error"></div>
  </div>

  <script type="module" src="../permissoes_pageColaborador/js/acesso_restrito.js"></script>

</body>

</html>