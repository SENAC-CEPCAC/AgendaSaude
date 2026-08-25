<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserColaborador;

class Authentication
{
    public function handle(Request $request, Closure $next, ...$niveis): Response
    {
        $usuario = Auth::user();

        if (! $usuario && $request->session()->has('colaborador_id')) {
            $usuario = UserColaborador::find($request->session()->get('colaborador_id'));

            if ($usuario && ! $usuario->ativo) {
                $request->session()->forget('colaborador_id');
                $usuario = null;
            }
        }

        if (! $usuario)
        {
            return redirect()->guest(route('acesso.login'));
        }

        if (!in_array((int) $usuario->nivel, array_map('intval', $niveis), true))
        {
            abort(403, 'Acesso negado, você não tem permissão para acessar esta página. Autentique-se!');
        }
        return $next($request);
    }
}