<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Empresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="email">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password_confirmation">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="dni">DNI</label>
                        <input type="text" name="dni" id="dni" class="form-control" value="{{ old('dni') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="ruc">RUC</label>
                        <input type="text" name="ruc" id="ruc" class="form-control" value="{{ old('ruc') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="celular">Celular</label>
                        <input type="text" name="celular" id="celular" class="form-control" value="{{ old('celular') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="archivo_cv">Archivo CV</label>
                        <input type="file" name="archivo_cv" id="archivo_cv" class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="rol">Rol</label>
                        <select name="rol" id="rol" class="form-control" required>
                            @foreach ($roles as $key => $value)
                                <option value="{{ $key }}" {{ old('rol') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">
                        Guardar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
