<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.loginP');
    }

    public function logar(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return redirect('/loginP')
                    ->withErrors('Usuário ou senha inválidos');
        }

        return to_route('agendamento.etapa1');
    }

    public function destroy()
    {
        Auth::logout();

        return to_route('login.loginP');
    }
}
