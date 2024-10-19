<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Rol -->
        <div class="mt-4">
            <x-input-label for="rol" :value="__('Select Role')" />
            <select id="rol" name="rol" class="block mt-1 w-full" onchange="toggleFields(this.value)">
                <option value="3" {{ old('rol') == 3 ? 'selected' : '' }}>Postulante</option>
                <option value="2" {{ old('rol') == 2 ? 'selected' : '' }}>Empresa</option>
            </select>
            <x-input-error :messages="$errors->get('rol')" class="mt-2" />
        </div>

        <!-- Campos adicionales para empresa -->
        <div id="empresaFields" class="hidden mt-4">

            <!-- RUC -->
            <div class="mt-4">
                <x-input-label for="ruc" :value="__('RUC')" />
                <x-text-input id="ruc" class="block mt-1 w-full" type="text" name="ruc" :value="old('ruc')" />
                <x-input-error :messages="$errors->get('ruc')" class="mt-2" />
            </div>

            <!-- Celular -->
            <div class="mt-4">
                <x-input-label for="celular" :value="__('Celular')" />
                <x-text-input id="celular" class="block mt-1 w-full" type="text" name="celular" :value="old('celular')" />
                <x-input-error :messages="$errors->get('celular')" class="mt-2" />
            </div>
        </div>



        <!-- Botón de registro -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        @if (session('status'))
            <div class="mt-4 text-sm text-gray-600">
                {{ session('status') }}
            </div>
        @endif
    </form>

    <script>
        function toggleFields(role) {
            const empresaFields = document.getElementById('empresaFields');


            if (role == '2') { // Empresa
                empresaFields.classList.remove('hidden');
            } else { // Postulante
                empresaFields.classList.add('hidden');

            }
        }

        // Set initial state based on old value (for validation failures)
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('rol');
            toggleFields(roleSelect.value);
        });
    </script>
</x-guest-layout>
