<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserApproval
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Verifica si el usuario está aprobado
        if ($user && !$user->is_approved) {
            // Redirige a una página que muestra un mensaje de espera
            return redirect()->route('pending.approval');
        }

        return $next($request);
    }
}
