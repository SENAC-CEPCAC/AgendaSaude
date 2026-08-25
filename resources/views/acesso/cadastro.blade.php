<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cadastro de paciente</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <!-- Seu CSS -->

    <link
        rel="stylesheet"
        href="/css/perfilPaciente.css">


    <!-- Fontes -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">


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
        </div>

    </div>

</div>


<!-- ========================================= -->
<!-- JAVASCRIPT -->
<!-- ========================================= -->

<script>


/*
|--------------------------------------------------------------------------
| ELEMENTOS
|--------------------------------------------------------------------------
*/

const step1 =
    document.getElementById('step1');

const step2 =
    document.getElementById('step2');

const btnProximo =
    document.getElementById('btnProximo');

const btnVoltar =
    document.getElementById('btnVoltar');

const btnCadastrar =
    document.getElementById('btnCadastrar');

const form =
    document.getElementById('formCadastroPaciente');

const step1Indicator =
    document.getElementById('step1Indicator');

const step2Indicator =
    document.getElementById('step2Indicator');

const step1Text =
    document.getElementById('step1Text');

const step2Text =
    document.getElementById('step2Text');

const erroSenha =
    document.getElementById('erroSenha');


/*
|--------------------------------------------------------------------------
| PRÓXIMO
|--------------------------------------------------------------------------
*/

btnProximo.addEventListener('click', function () {


    /*
    | Campos obrigatórios da etapa 1
    */

    const campos =
        step1.querySelectorAll(
            'input[required], select[required]'
        );


    let valido = true;


    /*
    | Validação
    */

    campos.forEach(function(campo) {

        if (!campo.checkValidity()) {

            campo.classList.add('is-invalid');

            valido = false;

        } else {

            campo.classList.remove('is-invalid');

        }

    });


    /*
    | Se tiver erro, não avança
    */

    if (!valido) {

        return;

    }


    /*
    | Esconde etapa 1
    */

    step1.classList.add('d-none');


    /*
    | Mostra etapa 2
    */

    step2.classList.remove('d-none');

    btnCadastrar.classList.remove('d-none');


    /*
    | Atualiza indicador
    */

    step1Indicator.classList.remove('bg-primary');

    step1Indicator.classList.add('bg-success');


    step2Indicator.classList.remove('bg-secondary');

    step2Indicator.classList.add('bg-primary');


    /*
    | Textos
    */

    step1Text.classList.remove('fw-semibold');

    step1Text.classList.add('text-muted');

    step2Text.classList.remove('text-muted');

    step2Text.classList.add('fw-semibold');


});


/*
|--------------------------------------------------------------------------
| VOLTAR
|--------------------------------------------------------------------------
*/

btnVoltar.addEventListener('click', function() {


    /*
    | Esconde etapa 2
    */

    step2.classList.add('d-none');


    /*
    | Mostra etapa 1
    */

    step1.classList.remove('d-none');

    btnCadastrar.classList.add('d-none');


    /*
    | Indicadores
    */

    step1Indicator.classList.remove('bg-success');

    step1Indicator.classList.add('bg-primary');


    step2Indicator.classList.remove('bg-primary');

    step2Indicator.classList.add('bg-secondary');


    /*
    | Textos
    */

    step1Text.classList.add('fw-semibold');

    step1Text.classList.remove('text-muted');

    step2Text.classList.remove('fw-semibold');

    step2Text.classList.add('text-muted');

});


/*
|--------------------------------------------------------------------------
| VALIDAR SENHA
|--------------------------------------------------------------------------
*/

form.addEventListener('submit', function(event) {


    const senha =
        document.getElementById('password').value;

    const confirmar =
        document.getElementById(
            'password_confirmation'
        ).value;


    if (senha !== confirmar) {

        event.preventDefault();

        erroSenha.classList.remove('d-none');

        return;

    }


    erroSenha.classList.add('d-none');

});


/*
|--------------------------------------------------------------------------
| MÁSCARA CPF
|--------------------------------------------------------------------------
*/

document
    .getElementById('cpf')
    .addEventListener('input', function(event) {


        let valor =
            event.target.value
                .replace(/\D/g, '')
                .substring(0, 11);


        valor =
            valor.replace(
                /(\d{3})(\d)/,
                '$1.$2'
            );


        valor =
            valor.replace(
                /(\d{3})(\d)/,
                '$1.$2'
            );


        valor =
            valor.replace(
                /(\d{3})(\d{1,2})$/,
                '$1-$2'
            );


        event.target.value = valor;

    });


/*
|--------------------------------------------------------------------------
| MÁSCARA CARTÃO SUS
|--------------------------------------------------------------------------
*/

document
    .getElementById('cartao_sus')
    .addEventListener('input', function(event) {


        let valor =
            event.target.value
                .replace(/\D/g, '')
                .substring(0, 15);


        event.target.value = valor;

    });


document
    .getElementById('celular')
    .addEventListener('input', function(event) {

        event.target.value = event.target.value
            .replace(/\D/g, '')
            .substring(0, 11);

    });


/*
|--------------------------------------------------------------------------
| REMOVER ERRO QUANDO CORRIGIR
|--------------------------------------------------------------------------
*/

form
    .querySelectorAll('input, select')
    .forEach(function(campo) {


        campo.addEventListener(
            'input',
            function() {

                if (campo.checkValidity()) {

                    campo.classList.remove(
                        'is-invalid'
                    );

                }

            }
        );


        campo.addEventListener(
            'change',
            function() {

                if (campo.checkValidity()) {

                    campo.classList.remove(
                        'is-invalid'
                    );

                }

            }
        );

    });

</script>


</body>

</html>