<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    /**
     * Muestra los usuarios no aprobados.
     *
     * @return \Illuminate\View\View
     */
    public function showUnapproved()
    {
        $usuarios = User::where('is_approved', false)->get();
        return view('usuarios_no_aprobados', ['usuarios' => $usuarios]);
    }

    /**
     * Cambia el estado de aprobación de un usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleApproval(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Cambia el estado de aprobación
        $user->is_approved = !$user->is_approved;
        $user->save();

        return redirect()->route('usuarios.no.aprobados')->with('success', 'Estado de aprobación cambiado con éxito.');
    }
}
