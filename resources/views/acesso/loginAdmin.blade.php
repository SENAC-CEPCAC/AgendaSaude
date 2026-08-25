<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Login - Colaborador</title>
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
      width: 320px;
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
    <h2 class="text-2xl font-bold">AGENDA SAÚDE</h2>
    <p class="text-xs text-slate-500 font-semibold mb-4 uppercase tracking-wide">Área do Colaborador</p>

    <form method="POST" action="{{ route('login.admin.attempt') }}">
      @csrf
      <h6 class="text-xs font-medium text-slate-700">Matrícula</h6>
      <input type="text" name="matricula" id="matricula" placeholder="Digite sua matrícula" value="{{ old('matricula') }}" required autofocus />

      <h6 class="text-xs font-medium text-slate-700">Senha</h6>
      <input type="password" name="password" id="password" placeholder="Digite sua senha" required />

      <div class="flex justify-end mt-1 mb-3">
        <a href="{{ route('recuperacao.recuperacao') }}" class="text-xs text-blue-600 hover:underline">Esqueci a senha</a>
      </div>

      <button type="submit">Entrar</button>
    </form>

    @if ($errors->any())
      <div class="error mt-3 p-2 bg-red-50 border border-red-200 rounded text-red-600 text-xs">
        {{ $errors->first() }}
      </div>
    @endif
  </div>

</body>

</html>
