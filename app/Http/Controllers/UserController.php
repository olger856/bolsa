<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Definir constantes para reglas de validación comunes
    private const VALIDATION_NAME = 'required|string|max:255';
    private const VALIDATION_EMAIL = 'required|string|email|max:255|unique:users';
    private const VALIDATION_PASSWORD = 'required|string|confirmed|min:8';
    private const VALIDATION_OPTIONAL_PASSWORD = 'nullable|string|confirmed|min:8';
    private const VALIDATION_CELULAR = 'nullable|digits:9';
    // Definir una constante para el prefijo de almacenamiento
    private const STORAGE_DISK = 'public/';


    /**
     * Mostrar el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = [
            1 => 'Administrador',
            2 => 'Empresa',
            3 => 'Postulante',
            4 => 'Supervisor'
        ];

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Almacenar un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            'name' => self::VALIDATION_NAME,
            'email' => self::VALIDATION_EMAIL,
            'password' => self::VALIDATION_PASSWORD,
            'dni' => 'nullable|digits:8|unique:users',
            'ruc' => 'nullable|digits:11',
            'celular' => self::VALIDATION_CELULAR,
            'archivo_cv' => 'nullable|file|mimes:pdf|max:2048',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rol' => 'required|integer|in:1,2,3,4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $archivo_cv_path = $this->handleFileUpload($request);
        $profile_photo_path = $this->handleProfilePhotoUpload($request);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'dni' => $request->input('dni'),
            'ruc' => $request->input('ruc'),
            'celular' => $request->input('celular'),
            'archivo_cv' => $archivo_cv_path,
            'profile_photo_path' => $profile_photo_path,
            'rol' => $request->input('rol'),
            'is_approved' => false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Mostrar la lista de postulantes.
     */
    public function indexPostulantes()
    {
        $users = User::where('rol', 3)->get(); // Filtrar solo los postulantes
        $pendingApprovalCount = User::where('is_approved', false)->where('rol', 3)->count();

        return view('admin.users.index', compact('users', 'pendingApprovalCount'));
    }

    /**
     * Mostrar la lista de empresas.
     */
    public function indexEmpresas()
    {
        $users = User::where('rol', 2)->get(); // Filtrar solo las empresas
        $pendingApprovalCount = User::where('is_approved', false)->where('rol', 2)->count();

        return view('admin.empresas.index', compact('users', 'pendingApprovalCount'));
    }

    /**
     * Mostrar la lista de supervisores.
     */
    public function indexSupervisores()
    {
        // Solo obtener supervisores de la empresa autenticada
        $users = User::where('rol', 4)->where('empresa_id', auth()->user()->id)->get();
        $pendingApprovalCount = User::where('is_approved', false)->where('rol', 4)->count();

        return view('empresa.supervisores.index', compact('users', 'pendingApprovalCount'));
    }

    /**
     * Mostrar el detalle de un usuario.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Mostrar el formulario para editar un usuario.
     */
    public function edit(User $user)
    {
        $roles = [
            1 => 'Administrador',
            2 => 'Empresa',
            3 => 'Postulante',
            4 => 'Supervisor'
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar un usuario en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            'name' => self::VALIDATION_NAME,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => self::VALIDATION_OPTIONAL_PASSWORD,
            'dni' => 'nullable|digits:8|unique:users,dni,' . $user->id,
            'ruc' => 'nullable|digits:11',
            'celular' => self::VALIDATION_CELULAR,
            'archivo_cv' => 'nullable|file|mimes:pdf|max:2048',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rol' => 'required|integer|in:1,2,3,4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $archivo_cv_path = $this->handleFileUpload($request, $user->archivo_cv);
        $profile_photo_path = $this->handleProfilePhotoUpload($request, $user->profile_photo_path);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
            'dni' => $request->input('dni'),
            'ruc' => $request->input('ruc'),
            'celular' => $request->input('celular'),
            'archivo_cv' => $archivo_cv_path,
            'profile_photo_path' => $profile_photo_path,
            'rol' => $request->input('rol'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Eliminar un usuario de la base de datos.
     */
    public function destroy(User $user)
    {
        if ($user->archivo_cv && Storage::exists(self::STORAGE_DISK . $user->archivo_cv)) {
            Storage::delete(self::STORAGE_DISK . $user->archivo_cv);
        }

        if ($user->profile_photo_path && Storage::exists(self::STORAGE_DISK . $user->profile_photo_path)) {
            Storage::delete(self::STORAGE_DISK . $user->profile_photo_path);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Funciones para la gestión de supervisores por las empresas
     */

    // Crear supervisor
    public function createSupervisor()
    {
        return view('empresa.supervisores.create');
    }

    // Almacenar un supervisor para la empresa
    public function storeSupervisor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => self::VALIDATION_NAME,
            'email' => self::VALIDATION_EMAIL,
            'password' => self::VALIDATION_PASSWORD,
            'dni' => 'nullable|digits:8|unique:users',
            'celular' => self::VALIDATION_CELULAR,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'dni' => $request->input('dni'),
            'celular' => $request->input('celular'),
            'rol' => 4, // Rol de supervisor
            'empresa_id' => auth()->user()->id, // Relacionar el supervisor con la empresa autenticada
        ]);

        return redirect()->route('empresa.supervisores.index')->with('success', 'Supervisor creado exitosamente.');
    }

    // Editar supervisor
    public function editSupervisor(User $supervisor)
    {
        return view('empresa.supervisores.edit', compact('supervisor'));
    }

    // Actualizar supervisor
    public function updateSupervisor(Request $request, User $supervisor)
    {
        $validator = Validator::make($request->all(), [
            'name' => self::VALIDATION_NAME,
            'email' => 'required|string|email|max:255|unique:users,email,' . $supervisor->id,
            'password' => self::VALIDATION_OPTIONAL_PASSWORD,
            'dni' => 'nullable|digits:8|unique:users,dni,' . $supervisor->id,
            'celular' => self::VALIDATION_CELULAR,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supervisor->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password') ? Hash::make($request->input('password')) : $supervisor->password,
            'dni' => $request->input('dni'),
            'celular' => $request->input('celular'),
        ]);

        return redirect()->route('empresa.supervisores.index')->with('success', 'Supervisor actualizado exitosamente.');
    }

    // Eliminar supervisor
    public function destroySupervisor(User $supervisor)
    {
        $supervisor->delete();
        return redirect()->route('empresa.supervisores.index')->with('success', 'Supervisor eliminado exitosamente.');
    }

    // Funciones de manejo de archivos
    private function handleFileUpload(Request $request, $currentFile = null)
    {
        if ($request->hasFile('archivo_cv')) {
            if ($currentFile && Storage::exists(self::STORAGE_DISK . $currentFile)) {
                Storage::delete(self::STORAGE_DISK . $currentFile);
            }

            return $request->file('archivo_cv')->store('cv', 'public');
        }

        return $currentFile; // Retorna el archivo actual si no hay nuevo
    }

    private function handleProfilePhotoUpload(Request $request, $currentPhoto = null)
    {
        if ($request->hasFile('profile_photo')) {
            if ($currentPhoto && Storage::exists(self::STORAGE_DISK . $currentPhoto)) {
                Storage::delete(self::STORAGE_DISK . $currentPhoto);
            }

            return $request->file('profile_photo')->store('profile_photos', 'public');
        }

        return $currentPhoto; // Retorna la foto actual si no hay nueva
    }
}
