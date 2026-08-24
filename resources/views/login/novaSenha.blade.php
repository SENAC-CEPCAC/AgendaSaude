<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Nova senha</title>


    <!-- CSS -->

    <link
        rel="stylesheet"
        href="/css/perfilPaciente.css">


    <!-- Google Fonts -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">


    <!-- Vite -->

    @vite(['resources/css/app.css'])

</head>


<body class="bg-[#f8fafc]">


<div class="main flex justify-center items-center h-screen">


    <!-- ========================================= -->
    <!-- CARD -->
    <!-- ========================================= -->

    <div
        class="border border-slate-50 rounded-xl shadow-md bg-white w-80 p-8">


        <!-- ========================================= -->
        <!-- TÍTULO -->
        <!-- ========================================= -->

        <div class="text-center">

            <h2 class="text-3xl font-bold">

                Nova senha

            </h2>

            <p class="text-gray-500 text-sm mt-2">

                Crie uma nova senha para sua conta.

            </p>

        </div>


        <!-- ========================================= -->
        <!-- INDICADOR -->
        <!-- ========================================= -->

        <div
            class="flex items-center justify-center mt-6 mb-7">


            <!-- ETAPA 1 -->

            <div class="text-center">

                <div
                    class="rounded-full bg-green-600 text-white flex items-center justify-center mx-auto"
                    style="width: 35px; height: 35px;">

                    ✓

                </div>

                <small
                    class="text-xs text-gray-400">

                    Código

                </small>

            </div>


            <!-- LINHA -->

            <div
                class="mx-3"
                style="width: 60px;">

                <hr>

            </div>


            <!-- ETAPA 2 -->

            <div class="text-center">

                <div
                    class="rounded-full bg-blue-900 text-white flex items-center justify-center mx-auto"
                    style="width: 35px; height: 35px;">

                    3

                </div>

                <small
                    class="text-xs font-semibold">

                    Nova senha

                </small>

            </div>

        </div>


        <!-- ========================================= -->
        <!-- FORMULÁRIO -->
        <!-- ========================================= -->

        <form
            action=""
            method="POST">

            @csrf


            <!-- ========================================= -->
            <!-- NOVA SENHA -->
            <!-- ========================================= -->

            <div>

                <label
                    for="password"
                    class="block text-sm font-medium ml-1 mb-2">

                    Nova senha

                </label>


                <input
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm outline-none focus:border-blue-900 focus:ring-1 focus:ring-blue-900"
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Digite sua nova senha"
                    minlength="8"
                    autocomplete="new-password"
                    required>

            </div>


            <!-- ========================================= -->
            <!-- CONFIRMAR SENHA -->
            <!-- ========================================= -->

            <div class="mt-4">

                <label
                    for="password_confirmation"
                    class="block text-sm font-medium ml-1 mb-2">

                    Confirmar nova senha

                </label>


                <input
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm outline-none focus:border-blue-900 focus:ring-1 focus:ring-blue-900"
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Digite novamente"
                    minlength="8"
                    autocomplete="new-password"
                    required>

            </div>


            <!-- ========================================= -->
            <!-- REQUISITOS -->
            <!-- ========================================= -->

            <div class="mt-3">

                <p
                    class="text-xs text-gray-500">

                    A senha deve possuir pelo menos
                    <strong>8 caracteres</strong>.

                </p>

            </div>


            <!-- ========================================= -->
            <!-- ERRO -->
            <!-- ========================================= -->

            <div
                id="erroSenha"
                class="hidden mt-3 text-red-500 text-xs">

                As senhas não são iguais.

            </div>


            <!-- ========================================= -->
            <!-- BOTÃO -->
            <!-- ========================================= -->

            <button
                type="submit"
                id="btnConfirmar"
                class="w-full bg-blue-900 hover:bg-blue-800 text-white rounded-lg mt-6 py-2 font-semibold transition">

                Confirmar nova senha

            </button>


        </form>


    </div>

</div>



<!-- ========================================= -->
<!-- JAVASCRIPT -->
<!-- ========================================= -->

<script>

const form =
    document.querySelector('form');

const password =
    document.getElementById('password');

const passwordConfirmation =
    document.getElementById('password_confirmation');

const erroSenha =
    document.getElementById('erroSenha');


form.addEventListener('submit', function(event) {


    /*
    |--------------------------------------------------------------------------
    | VERIFICAR SE AS SENHAS SÃO IGUAIS
    |--------------------------------------------------------------------------
    */

    if (
        password.value !==
        passwordConfirmation.value
    ) {

        event.preventDefault();

        erroSenha.classList.remove('hidden');

        passwordConfirmation.classList.add(
            'border-red-500'
        );

        passwordConfirmation.focus();

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | REMOVER ERRO
    |--------------------------------------------------------------------------
    */

    erroSenha.classList.add('hidden');

    passwordConfirmation.classList.remove(
        'border-red-500'
    );


});


/*
|--------------------------------------------------------------------------
| REMOVER ERRO AO DIGITAR
|--------------------------------------------------------------------------
*/

passwordConfirmation.addEventListener(
    'input',
    function() {

        if (
            password.value ===
            passwordConfirmation.value
        ) {

            erroSenha.classList.add('hidden');

            passwordConfirmation.classList.remove(
                'border-red-500'
            );

        }

    }
);

</script>


</body>

</html>