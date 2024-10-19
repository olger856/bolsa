<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'dni' => ['nullable', 'digits:8', 'unique:users'],
            'ruc' => ['nullable', 'digits:11'],
            'celular' => ['nullable', 'digits:9'],
            'rol' => ['required', 'integer', 'in:1,2,3,4'],
        ]);

        // Crear el usuario con is_approved en false
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dni' => $request->dni,
            'ruc' => $request->ruc,
            'celular' => $request->celular,
            'rol' => $request->rol,
            'is_approved' => false,
        ]);

        // Aquí podrías agregar lógica para notificar al admin sobre la nueva solicitud de usuario.

        // Redirige a una página de confirmación o a la página de inicio de sesión
        return redirect()->route('register')->with('status', 'Tu solicitud de registro ha sido enviada. Espera la aprobación del administrador.');
    }
}
