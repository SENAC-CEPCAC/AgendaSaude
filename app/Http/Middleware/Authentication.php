<?php

namespace App\Http\Middleware;

use closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use lluminate\Auth\AutheticationException;

class Authentication
{
    public function handle( Request $request, Closure $next, $niveis): Response
    {
        if(!Auth::check())
        {
            throw new AuthenticationException();
        }

        if(!in_array(Auth::user()->nivel, $niveis))
        {
            abort(403, 'Acesso negado, você não tem permissão para acessar esta página. Autentique-se!');
        }
        return $next($request);
    }
}