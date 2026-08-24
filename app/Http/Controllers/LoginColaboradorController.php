<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class LoginColaboradorController extends Controller
{
    /**
     * Exibe o formulário de login para colaboradores (tela loginAdmin).
     */
    public function index()
    {
        return view('acesso.loginAdmin');
    }

    /**
     * Realiza a tentativa de login do colaborador por matrícula e senha.
     */
    public function logar(Request $request)
    {
        $request->validate([
            'matricula' => 'required|string',
            'password' => 'required|string',
        ], [
            'matricula.required' => 'O número de matrícula é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        $credentials = [
            'matricula' => $request->matricula,
            'password' => $request->password,
        ];

        $remember = $request->boolean('remember');
        $authenticated = false;

        try {
            // Autentica pelo guard de colaboradores
            if (Auth::guard('colaborador')->attempt($credentials, $remember)) {
                $authenticated = true;
            } elseif (Auth::attempt($credentials, $remember)) {
                // Fallback para guard web se aplicável
                $authenticated = true;
            }
        } catch (QueryException $exception) {
            report($exception);
        }

        if (!$authenticated) {
            return redirect()->route('login.admin')
                ->withErrors('Matrícula ou senha inválidos.')
                ->withInput($request->only('matricula'));
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dash.index'));
    }

    /**
     * Finaliza a sessão do colaborador (logout).
     */
    public function destroy(Request $request)
    {
        Auth::guard('colaborador')->logout();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.admin');
    }
}
