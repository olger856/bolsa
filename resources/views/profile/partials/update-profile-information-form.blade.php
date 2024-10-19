<section class="bg-white p-6 rounded-lg shadow-md">
    <form method="post" action="{{ route('profile.update') }}" class="flex flex-col md:flex-row" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Columna izquierda: Foto y detalles del usuario -->
        <div class="md:w-1/3 flex flex-col items-center border-r border-gray-200 pr-6 pb-6">
            <div class="relative mb-4 group">
                @if ($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" class="w-32 h-32 object-cover rounded-full border-4 border-gray-300 shadow-md profile-photo" />
                @else
                    <div class="w-32 h-32 flex items-center justify-center bg-gray-200 rounded-full border-4 border-gray-300 shadow-md">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif

                <!-- Input para subir foto, oculto -->
                <input id="profile_photo_input" name="profile_photo" type="file" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="updateProfilePhoto(event)" />
                
                <!-- Overlay con ícono de editar -->
                <div class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 cursor-pointer flex items-center justify-center shadow-md hover:bg-blue-600 transition-colors duration-300"
                     onclick="document.getElementById('profile_photo_input').click();"
                     title="Actualizar foto">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-8 0l9-9" />
                    </svg>
                </div>

                <!-- Overlay opcional con texto "Actualizar foto" al hacer hover -->
                <div class="absolute inset-0 rounded-full bg-black bg-opacity-0 flex items-center justify-center opacity-0 group-hover:bg-opacity-50 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                     onclick="document.getElementById('profile_photo_input').click();">
                    <span class="text-white text-sm">Actualizar foto</span>
                </div>
            </div>
            <h3 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h3>
            <p class="text-sm text-gray-600">{{ $user->email }}</p>
        </div>

        <!-- Columna derecha: Formulario de edición -->
        <div class="md:w-2/3 mt-6 md:mt-0 pl-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Información de perfil') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Actualice la información del perfil y la dirección de correo electrónico de su cuenta.") }}
                </p>
            </header>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <div class="mt-6 space-y-6">
                <div class="w-full">
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="w-full">
                    <x-input-label for="email" :value="__('Correo')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Opción de subir CV, visible solo para el postulante -->
                @if ($user->rol === 3)
                    <div class="w-full">
                        <x-input-label for="archivo_cv" :value="__('Archivo CV')" />

                        <!-- Mostrar el archivo actual si existe -->
                        @if ($user->archivo_cv)
                            <div class="mt-4 p-4 border rounded bg-gray-100 flex items-center justify-between">
                                <div class="flex items-center">
                                    <p class="text-sm text-gray-600 mr-2">
                                        {{ __('Visualizar tu CV:') }}
                                    </p>
                                    <a href="{{ asset('storage/' . $user->archivo_cv) }}" target="_blank" class="flex items-center bg-gray-200 rounded p-2">
                                        <img src="https://images.vexels.com/media/users/3/206291/isolated/lists/80b5970dfbfe49c4bd7de59cc3129008-trazo-de-hojas-de-papel-escrito.png" alt="Document Icon" class="h-8 w-8">
                                    </a>
                                </div>
                                <button type="button" class="ml-4 bg-blue-500 text-white rounded px-3 py-1" onclick="document.getElementById('archivo_cv_input').click();">
                                    {{ __('Editar') }}
                                </button>
                                <input id="archivo_cv_input" name="archivo_cv" type="file" class="hidden" accept=".pdf,.doc,.docx" onchange="updateFileName(event)" />
                            </div>
                        @else
                            <p class="mt-2 text-sm text-gray-600">
                                {{ __('No CV uploaded.') }}
                            </p>
                        @endif

                        <div id="update-prompt" class="mt-2 text-sm text-gray-600 hidden">
                            {{ __('¿Desea actualizar su archivo?') }}
                            <button type="button" id="preview-button" class="bg-green-500 text-white rounded px-3 py-1 ml-2" onclick="previewFile()">
                                {{ __('Previsualizar') }}
                            </button>
                        </div>
                    </div>
                @endif

                <div class="flex justify-start">
                    <x-primary-button class="mt-4">{{ __('Actualizar') }}</x-primary-button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 mt-2 ml-4">
                            {{ __('Saved.') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    function updateProfilePhoto(event) {
        const input = event.target;
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const profilePhoto = document.querySelector('.profile-photo');
                profilePhoto.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function updateFileName(event) {
        const input = event.target;
        const fileName = input.files[0] ? input.files[0].name : '';

        const updatePrompt = document.getElementById('update-prompt');
        if (fileName) {
            updatePrompt.classList.remove('hidden');
            fileUrl = URL.createObjectURL(input.files[0]);
        } else {
            updatePrompt.classList.add('hidden');
        }
    }

    function previewFile() {
        if (fileUrl) {
            window.open(fileUrl, '_blank');
        } else {
            alert('No hay archivo seleccionado para previsualizar.');
        }
    }

    let fileUrl = null;
</script>
