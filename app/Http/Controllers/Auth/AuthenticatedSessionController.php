<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login'); 
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autenticación del usuario
        $request->authenticate();

        // Regenera la sesión para evitar ataques de fijación de sesión
        $request->session()->regenerate();

        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Redirección basada en el rol del usuario
        switch ($user->rol) {
            case 1: // Admin
                return redirect()->intended('/admin/dashboard');
            case 2: // Empresa
                return redirect()->intended('/empresa/perfil');
            case 3: // Postulante
                return redirect()->intended('/postulante/perfil');
            case 4: // Supervisor
                return redirect()->intended('/supervisor/dashboard');
            default:
                // Redirección por defecto si el rol no coincide
                return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Cierra la sesión del usuario
        Auth::guard('web')->logout();

        // Invalida la sesión actual
        $request->session()->invalidate();

        // Regenera el token CSRF
        $request->session()->regenerateToken();

        // Redirige al usuario a la página principal
        return redirect('/');
    }
}
