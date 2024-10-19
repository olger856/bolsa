<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Crear Nueva Oferta Laboral') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <form method="POST" action="{{ route('job_offers.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Descripción -->
                        <div>
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" class="mt-1 block w-full" required></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Ubicación -->
                        <div>
                            <x-input-label for="location" :value="__('Ubicación')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Salario -->
                        <div>
                            <x-input-label for="salary" :value="__('Salario')" />
                            <x-text-input id="salary" name="salary" type="number" step="0.01" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                        </div>

                        <!-- Imagen -->
                        <div>
                            <x-input-label for="image" :value="__('Imagen')" />
                            <input id="image" name="image" type="file" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Fecha y hora de inicio -->
                        <div>
                            <x-input-label for="start_date" :value="__('Fecha y Hora de Inicio')" />
                            <x-text-input id="start_date" name="start_date" type="datetime-local" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        <!-- Fecha y hora de fin -->
                        <div>
                            <x-input-label for="end_date" :value="__('Fecha y Hora de Fin')" />
                            <x-text-input id="end_date" name="end_date" type="datetime-local" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-primary-button>{{ __('Crear Oferta') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
