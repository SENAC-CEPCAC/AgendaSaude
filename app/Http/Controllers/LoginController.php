<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class LoginController extends Controller
{
    public function index()
    {
        return view('acesso.login');
    }

    public function logar(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $authenticated = false;

        try {
            $authenticated = Auth::attempt($credentials);
        } catch (QueryException $exception) {
            report($exception);
        }

        if (!$authenticated) {
            return redirect()->route('acesso.login')
                    ->withErrors('Usuário ou senha inválidos');
        }

        $request->session()->regenerate();

        if ((int) Auth::user()->nivel === 4) {
            return to_route('adm.adm');
        }

        return to_route('dash.index');
    }

    public function destroy()
    {
        Auth::logout();
        request()->session()->forget('colaborador_id');
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return to_route('acesso.index');
    }
}
