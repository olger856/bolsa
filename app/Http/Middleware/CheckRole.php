<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Asegúrate de que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect('login');
        }

        // Obtén el usuario autenticado
        $user = Auth::user();

        // Verifica el rol del usuario
        if ($user->rol != $role) {
            // Redirige si el rol no coincide
            return redirect('unauthorized');
        }

        return $next($request);
    }
}
