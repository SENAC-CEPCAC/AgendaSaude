<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente - Agenda Saúde</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilo customizado -->
    <link rel="stylesheet" href="/css/perfilPaciente.css">

    <!-- Fontes -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
</head>

<body class="bg-light">


<<<<<<<<< Temporary merge branch 1:resources/views/acesso/cadastro.blade.php
        <div class="border border-slate-50 rounded-xl shadow-md bg-white w-80 h-170  p-13 ">
            <h2 class="text-3xl ">Crie sua conta</h2>
            <div>
                <h4 class="nome text-xs mt-6">Nome</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="text" name="nome" id="name"
                    placeholder="Seu nome">
                <h4 class="text-xs pt-2 mt-2">Sobrenome</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="text" name="sobrenome" id="sobrenome "

                    placeholder="Seu sobrenome">
                <h4 class="text-xs pt-2 mt-2">CPF</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="text" name="cpf" id="cpf"
                    placeholder="000.000.000-00">
                <h4 class="text-xs pt-2 mt-2">RG</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="text" name="rg" id="rg"
                    placeholder="000.000.000-0">
                <h4 class="nome text-xs pt-2 mt-2">Telefone (WhatsApp)</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="text" name="telefone" id="telefone"
                    placeholder="(00) 00000-0000">
                <h4 class="nome text-xs pt-2 mt-2">E-mail</h4>
                <input class="input border-1 pt-1 border-gray-300  rounded-md pl-9 placeholder:text-sm" type="email" name="email" id="email"
                    placeholder="seu@email.com">
                <h4 class="nome text-xs pt-2 mt-2">Senha</h4>
                <input class="input border-1 pt-1 border-gray-300 rounded-md pl-9 placeholder:text-sm" type="password" name="password" id="password"
                    placeholder="Senha">


            </div>
            <div class="flex  mt-3">
                <input type="checkbox" class="mr-2 mt-4">
                <p class="lembrar ml- text-sm mt-4">Aceito os termos de uso e a política de privacidade da plataforma</p>
            </div>
            <a href="{{ route('acesso.login') }}">
            <button class="butao cursor-pointer hover:bg-blue-700 font-bold bg-clip-border px-22 py-1 bg-blue-500 text-white rounded-lg mt-6"
                type="submit" login-url="{{ route('acesso.login') }}">Entrar</button>
            </a>
=========
<div class="container py-5">


    <!-- ========================================= -->
    <!-- CABEÇALHO -->
    <!-- ========================================= -->

    <div class="text-center mb-4">

        <h2 class="fw-semibold">
            Crie sua conta
        </h2>

        <p class="text-muted">
            Cadastre seus dados para acessar a plataforma.
        </p>

    </div>


    <!-- ========================================= -->
    <!-- CARD -->
    <!-- ========================================= -->

    <div class="card shadow-sm border-0 mx-auto"
         style="max-width: 850px;">

        <div class="card-body p-4 p-md-5">


            <!-- ================================= -->
            <!-- PROGRESSO -->
            <!-- ================================= -->

            <div class="d-flex align-items-center justify-content-center mb-5">


                <!-- ETAPA 1 -->

                <div class="text-center">

                    <div
                        id="step1Indicator"
                        class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                        style="width: 42px; height: 42px;">

                        1

                    </div>

                    <small
                        id="step1Text"
                        class="d-block mt-2 fw-semibold">

                        Dados pessoais

                    </small>

                </div>


                <!-- LINHA -->

                <div
                    class="mx-3"
                    style="width: 120px;">

                    <hr>

                </div>


                <!-- ETAPA 2 -->

                <div class="text-center">

                    <div
                        id="step2Indicator"
                        class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                        style="width: 42px; height: 42px;">

                        2

                    </div>

                    <small
                        id="step2Text"
                        class="d-block mt-2 text-muted">

                        Acesso

                    </small>

                </div>

            </div>


            <!-- ================================= -->
            <!-- FORMULÁRIO -->
            <!-- ================================= -->

            <form
                id="formCadastroPaciente"
                action="{{ route('permissao_colaborador.cadastro.store') }}"
                method="POST">

                @csrf


                <!-- ================================= -->
                <!-- ETAPA 1 -->
                <!-- ================================= -->

                <div id="step1">


                    <h4 class="mb-4">

                        Dados pessoais

                    </h4>


                    <div class="row g-3">


                        <!-- NOME -->

                        <div class="col-md-8">

                            <label
                                for="nome_completo"
                                class="form-label">

                                Nome completo *

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="nome_completo"
                                name="nome_completo"
                                placeholder="Digite seu nome completo"
                                value="{{ old('nome_completo') }}"
                                required>

                        </div>


                        <!-- APELIDO -->

                        <div class="col-md-4">

                            <label
                                for="apelido"
                                class="form-label">

                                Apelido

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="apelido"
                                name="apelido"
                                placeholder="Opcional"
                                value="{{ old('apelido') }}">

                        </div>


                        <!-- MÃE -->

                        <div class="col-12">

                            <label
                                for="nome_mae"
                                class="form-label">

                                Nome da mãe *

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="nome_mae"
                                name="nome_mae"
                                placeholder="Digite o nome completo da mãe"
                                value="{{ old('nome_mae') }}"
                                required>

                        </div>


                        <!-- CPF -->

                        <div class="col-md-6">

                            <label
                                for="cpf"
                                class="form-label">

                                CPF *

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="cpf"
                                name="cpf"
                                placeholder="000.000.000-00"
                                maxlength="14"
                                value="{{ old('cpf') }}"
                                required>

                        </div>


                        <!-- SUS -->

                        <div class="col-md-6">

                            <label
                                for="cartao_sus"
                                class="form-label">

                                Cartão SUS *

                            </label>

                            <input
    type="text"
    class="form-control"
    id="cartao_sus"
    name="cartao_sus"
    placeholder="000 0000 0000 0000"
    inputmode="numeric"
    maxlength="15"
    value="{{ old('cartao_sus') }}"
    required>

                        </div>


                        <!-- DATA -->

                        <div class="col-md-6">

                            <label
                                for="celular"
                                class="form-label">

                                Número de celular *

                            </label>

                            <input
                                type="tel"
                                class="form-control"
                                id="celular"
                                name="celular"
                                inputmode="numeric"
                                maxlength="11"
                                pattern="[0-9]{11}"
                                placeholder="(00) 00000-0000"
                                value="{{ old('celular') }}"
                                required>

                        </div>


                        <!-- DATA -->

                        <div class="col-md-4">

                            <label
                                for="data_nascimento"
                                class="form-label">

                                Data de nascimento *

                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="data_nascimento"
                                name="data_nascimento"
                                value="{{ old('data_nascimento') }}"
                                required>

                        </div>


                        <!-- SEXO -->

                        <div class="col-md-4">

                            <label
                                for="sexo"
                                class="form-label">

                                Sexo *

                            </label>

                            <select
                                class="form-select"
                                id="sexo"
                                name="sexo"
                                required>

                                <option value="">
                                    Selecione
                                </option>

                                <option value="masculino">
                                    Masculino
                                </option>

                                <option value="feminino">
                                    Feminino
                                </option>

                                <option value="outro">
                                    Outro
                                </option>

                            </select>

                        </div>


                        <!-- RAÇA -->

                        <div class="col-md-4">

                            <label
                                for="raca_cor"
                                class="form-label">

                                Raça/Cor *

                            </label>

                            <select
                                class="form-select"
                                id="raca_cor"
                                name="raca_cor"
                                required>

                                <option value="">
                                    Selecione
                                </option>

                                <option value="branca">
                                    Branca
                                </option>

                                <option value="preta">
                                    Preta
                                </option>

                                <option value="parda">
                                    Parda
                                </option>

                                <option value="amarela">
                                    Amarela
                                </option>

                                <option value="indigena">
                                    Indígena
                                </option>

                                <option value="nao_informado">
                                    Não informado
                                </option>

                            </select>

                        </div>


                        <!-- ESCOLARIDADE -->

                        <div class="col-12">

                            <label
                                for="escolaridade"
                                class="form-label">

                                Escolaridade *

                            </label>

                            <select
                                class="form-select"
                                id="escolaridade"
                                name="escolaridade"
                                required>

                                <option value="">
                                    Selecione
                                </option>

                                <option value="nao_alfabetizado">
                                    Não alfabetizado
                                </option>

                                <option value="fundamental_incompleto">
                                    Ensino fundamental incompleto
                                </option>

                                <option value="fundamental_completo">
                                    Ensino fundamental completo
                                </option>

                                <option value="medio_incompleto">
                                    Ensino médio incompleto
                                </option>

                                <option value="medio_completo">
                                    Ensino médio completo
                                </option>

                                <option value="superior_incompleto">
                                    Ensino superior incompleto
                                </option>

                                <option value="superior_completo">
                                    Ensino superior completo
                                </option>

                                <option value="pos_graduacao">
                                    Pós-graduação
                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- BOTÃO -->

                    <div class="d-flex justify-content-end mt-5">

                        <button
                            type="button"
                            id="btnProximo"
                            class="btn btn-primary px-4">

                            Próximo →

                        </button>

                    </div>

                </div>


                <!-- ================================= -->
                <!-- ETAPA 2 -->
                <!-- ================================= -->

                <div
                    id="step2"
                    class="d-none">


                    <h4 class="mb-4">

                        Dados de acesso

                    </h4>


                    <div class="row g-3">


                        <!-- LOGIN -->

                        <div class="col-12">

    <label
        for="email"
        class="form-label">

        E-mail *

    </label>

    <input
        type="email"
        class="form-control"
        id="email"
        name="email"
        placeholder="Digite seu e-mail"
        value="{{ old('email') }}"
        autocomplete="email"
        required>

    <div class="form-text">

        Você utilizará este e-mail para acessar sua conta.

    </div>

</div>

                            <small class="text-muted">

                                Esse será utilizado para entrar na plataforma.

                            </small>

                        </div>


                        <!-- SENHA -->

                        <div class="col-md-6">

                            <label
                                for="password"
                                class="form-label">

                                Senha *

                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Mínimo 8 caracteres"
                                minlength="8"
                                required>

                        </div>


                        <!-- CONFIRMAR -->

                        <div class="col-md-6">

                            <label
                                for="password_confirmation"
                                class="form-label">

                                Confirmar senha *

                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Digite novamente"
                                minlength="8"
                                required>

                        </div>

                    </div>


                    <!-- ERRO -->

                    <div
                        id="erroSenha"
                        class="alert alert-danger mt-4 d-none">

                        As senhas não são iguais.

                    </div>


                    <!-- BOTÕES -->

                    <div
                        class="d-flex justify-content-between mt-5">


                        <button
                            type="button"
                            id="btnVoltar"
                            class="btn btn-secondary">

                            ← Voltar

                        </button>


                        <button
                            type="submit"
                            id="btnCadastrar"
                            class="btn btn-success px-4 d-none">

                            Cadastrar

                        </button>

                    </div>

                </div>


            </form>

>>>>>>>>> Temporary merge branch 2:resources/views/permissao_colaborador/cadastro.blade.php
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript do Formulário -->
    <script>
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const btnProximo = document.getElementById('btnProximo');
        const btnVoltarStep2 = document.getElementById('btnVoltarStep2');
        const form = document.getElementById('formCadastroPaciente');
        const step1Indicator = document.getElementById('step1Indicator');
        const step2Indicator = document.getElementById('step2Indicator');
        const step1Text = document.getElementById('step1Text');
        const step2Text = document.getElementById('step2Text');
        const erroSenha = document.getElementById('erroSenha');

        function mostrarEtapa2() {
            step1.classList.add('d-none');
            step2.classList.remove('d-none');

            step1Indicator.classList.remove('bg-primary');
            step1Indicator.classList.add('bg-success');
            step1Text.classList.remove('fw-semibold', 'text-primary');
            step1Text.classList.add('text-muted');

            step2Indicator.classList.remove('bg-secondary');
            step2Indicator.classList.add('bg-primary');
            step2Text.classList.remove('text-muted');
            step2Text.classList.add('fw-semibold', 'text-primary');
        }

        function mostrarEtapa1() {
            step2.classList.add('d-none');
            step1.classList.remove('d-none');

            step1Indicator.classList.remove('bg-success');
            step1Indicator.classList.add('bg-primary');
            step1Text.classList.remove('text-muted');
            step1Text.classList.add('fw-semibold', 'text-primary');

            step2Indicator.classList.remove('bg-primary');
            step2Indicator.classList.add('bg-secondary');
            step2Text.classList.remove('fw-semibold', 'text-primary');
            step2Text.classList.add('text-muted');
        }

        // Validação da Etapa 1 ao clicar em "Próximo"
        btnProximo.addEventListener('click', function() {
            const camposEtapa1 = step1.querySelectorAll('input[required], select[required]');
            let valido = true;

            camposEtapa1.forEach(function(campo) {
                // Validações customizadas
                if (campo.id === 'cpf') {
                    const cpfLimpo = campo.value.replace(/\D/g, '');
                    if (cpfLimpo.length !== 11) {
                        campo.classList.add('is-invalid');
                        valido = false;
                        return;
                    }
                }

                if (campo.id === 'cartao_sus') {
                    const susLimpo = campo.value.replace(/\D/g, '');
                    if (susLimpo.length !== 15) {
                        campo.classList.add('is-invalid');
                        valido = false;
                        return;
                    }
                }

                if (campo.id === 'celular') {
                    const telLimpo = campo.value.replace(/\D/g, '');
                    if (telLimpo.length < 10 || telLimpo.length > 11) {
                        campo.classList.add('is-invalid');
                        valido = false;
                        return;
                    }
                }

                if (!campo.value.trim() || !campo.checkValidity()) {
                    campo.classList.add('is-invalid');
                    valido = false;
                } else {
                    campo.classList.remove('is-invalid');
                }
            });

            if (valido) {
                mostrarEtapa2();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // Voltar para Etapa 1
        btnVoltarStep2.addEventListener('click', function() {
            mostrarEtapa1();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Validação no envio final do formulário
        form.addEventListener('submit', function(event) {
            const email = document.getElementById('email');
            const senha = document.getElementById('password');
            const confirmar = document.getElementById('password_confirmation');
            let valido = true;

            if (!email.value.trim() || !email.checkValidity()) {
                email.classList.add('is-invalid');
                valido = false;
            } else {
                email.classList.remove('is-invalid');
            }

            if (!senha.value || senha.value.length < 8) {
                senha.classList.add('is-invalid');
                valido = false;
            } else {
                senha.classList.remove('is-invalid');
            }

            if (!confirmar.value || confirmar.value.length < 8) {
                confirmar.classList.add('is-invalid');
                valido = false;
            } else {
                confirmar.classList.remove('is-invalid');
            }

            if (senha.value && confirmar.value && senha.value !== confirmar.value) {
                erroSenha.classList.remove('d-none');
                confirmar.classList.add('is-invalid');
                valido = false;
            } else {
                erroSenha.classList.add('d-none');
            }

            if (!valido) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        // Máscara de CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 11);
            if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
            else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
            else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
            e.target.value = v;
        });

        // Máscara de Cartão SUS (somente números, 15 dígitos)
        document.getElementById('cartao_sus').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 15);
        });

        // Máscara de Celular
        document.getElementById('celular').addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 11);
            if (v.length > 10) {
                v = v.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (v.length > 5) {
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else if (v.length > 2) {
                v = v.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            }
            e.target.value = v;
        });

        // Remover classes de erro ao digitar
        form.querySelectorAll('input, select').forEach(function(campo) {
            campo.addEventListener('input', function() {
                if (campo.value.trim()) campo.classList.remove('is-invalid');
            });
            campo.addEventListener('change', function() {
                if (campo.value.trim()) campo.classList.remove('is-invalid');
            });
        });

        // Se houver erros em campos do Step 2 retornados do backend, abre direto no Step 2
        @if ($errors->has('email') || $errors->has('password') || $errors->has('password_confirmation'))
            document.addEventListener('DOMContentLoaded', function() {
                mostrarEtapa2();
            });
        @endif
    </script>
</body>

</html>