<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Detalles de la Postulación') }}
        </h2>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-5xl w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 lg:p-10 space-y-10">
                
                <!-- Información del Postulante -->
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-300 dark:border-gray-700">Información del Postulante</h3>
                    <div class="flex flex-col items-center">
                        <img src="{{ $application->postulante->profile_photo_path ? asset('storage/' . $application->postulante->profile_photo_path) : asset('images/default-profile.png') }}" 
                             alt="Imagen del Postulante" 
                             class="w-32 h-32 rounded-full border-4 border-blue-500 mb-4 shadow-lg">
                        <p class="text-xl text-gray-900 dark:text-white font-semibold">{{ $application->postulante->name }}</p>
                        <p class="text-md text-gray-600 dark:text-gray-400">{{ $application->postulante->email }}</p>
                        <p class="text-md text-gray-600 dark:text-gray-400"><strong>DNI:</strong> {{ $application->postulante->dni }}</p> <!-- Agregado -->
                        <p class="text-md text-gray-600 dark:text-gray-400"><strong>Celular:</strong> {{ $application->postulante->celular }}</p> <!-- Agregado -->
                    </div>
                </div>

                <!-- Información de la Oferta Laboral -->
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-300 dark:border-gray-700">Información de la Oferta Laboral</h3>
                    <div class="space-y-4 text-gray-800 dark:text-gray-200">
                        <p><strong>Título:</strong> {{ $application->jobOffer->title }}</p>
                        <p><strong>Descripción:</strong> {{ $application->jobOffer->description }}</p>
                        <p><strong>Ubicación:</strong> {{ $application->jobOffer->location }}</p>
                        <p><strong>Salario:</strong> <span class="text-blue-600 dark:text-blue-400">S/{{ number_format($application->jobOffer->salary, 2) }}</span></p>
                    </div>
                </div>

                <!-- Estado de la Postulación -->
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-300 dark:border-gray-700">Estado de la Postulación</h3>
                    <p>
                        @switch($application->status)
                            @case(1)
                                <span class="bg-yellow-200 text-yellow-800 py-2 px-4 rounded-full text-sm font-semibold shadow-md">
                                    Pendiente
                                </span>
                                @break
                            @case(2)
                                <span class="bg-green-200 text-green-800 py-2 px-4 rounded-full text-sm font-semibold shadow-md">
                                    Aprobado
                                </span>
                                @break
                            @default
                                <span class="bg-red-200 text-red-800 py-2 px-4 rounded-full text-sm font-semibold shadow-md">
                                    Rechazado
                                </span>
                        @endswitch
                    </p>
                </div>

                <!-- CV del Postulante -->
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-300 dark:border-gray-700">CV del Postulante</h3>
                    @if ($application->postulante->archivo_cv)
                        <a href="{{ asset('storage/' . $application->postulante->archivo_cv) }}" 
                           class="text-blue-500 dark:text-blue-400 hover:underline font-semibold" 
                           target="_blank">
                            Ver CV del Postulante
                        </a>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No hay CV disponible.</p>
                    @endif
                </div>

                <!-- Botón de Volver -->
                <div class="flex justify-center">
                    <a href="{{ route('postulaciones.index') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-8 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                        Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
