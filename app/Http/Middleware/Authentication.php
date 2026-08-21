<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authentication
{
    public function handle(Request $request, Closure $next, ...$niveis): Response
    {
        if(!Auth::check())
        {
            return redirect()->guest(route('acesso.login'));
        }

        if (!in_array((int) Auth::user()->nivel, array_map('intval', $niveis), true))
        {
            abort(403, 'Acesso negado, você não tem permissão para acessar esta página. Autentique-se!');
        }
        return $next($request);
    }
}