<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">
                {{ __('Postulaciones') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 lg:p-8">
                
                <!-- Filtros -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-6 space-y-4 md:space-y-0">
                    <!-- Dropdown para filtrar por oferta laboral -->
                    <form action="{{ route('postulaciones.index') }}" method="GET" class="flex items-center space-x-2">
                        <label for="job_offer_id" class="text-gray-700 dark:text-gray-300 font-medium">Filtrar por Oferta:</label>
                        <select name="job_offer_id" id="job_offer_id" class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" onchange="this.form.submit()">
                            <option value="">Todas las Ofertas</option>
                            @foreach ($jobOffers as $jobOffer)
                                <option value="{{ $jobOffer->id }}" {{ request('job_offer_id') == $jobOffer->id ? 'selected' : '' }}>
                                    {{ $jobOffer->title }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Campo de búsqueda -->
                    <form action="{{ route('postulaciones.index') }}" method="GET" class="flex items-center space-x-2">
                        <input type="text" name="search" placeholder="Buscar postulante..." value="{{ request('search') }}" class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md flex items-center transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1111.25 4.5a7.5 7.5 0 018.4 12.15z" />
                            </svg>
                            Buscar
                        </button>
                    </form>
                </div>

                <!-- Notificación de éxito -->
                @if (session('status'))
                    <script>
                        window.addEventListener('DOMContentLoaded', (event) => {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: '{{ session('status') }}',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'top-end'
                            });
                        });
                    </script>
                @endif

                <!-- Lista de Postulaciones -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($postulaciones as $application)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="p-4 flex items-center space-x-4">
                                <img src="{{ $application->postulante->profile_photo_path ? asset('storage/' . $application->postulante->profile_photo_path) : asset('images/default-profile.png') }}" 
                                     alt="Imagen del Postulante" 
                                     class="w-16 h-16 rounded-full object-cover shadow-md">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $application->postulante->name ?? 'Sin postulante' }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $application->postulante->email ?? 'Sin email' }}</p>
                                </div>
                            </div>
                            <div class="px-4 py-2">
                                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Oferta Laboral:</strong> {{ $application->jobOffer->title }}</p>
                                <p class="mt-2">
                                    @switch($application->status)
                                        @case(1)
                                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                                Pendiente
                                            </span>
                                            @break
                                        @case(2)
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                Aprobado
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                                Rechazado
                                            </span>
                                    @endswitch
                                </p>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 flex justify-end space-x-2">
                                <a href="{{ route('postulaciones.show', $application->id) }}" class="flex items-center bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-3 py-1 rounded-md transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Detalle
                                </a>
                                @if ($application->postulante->archivo_cv)
                                    <a href="{{ asset('storage/' . $application->postulante->archivo_cv) }}" class="flex items-center bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-3 py-1 rounded-md transition-colors" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Ver CV
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">No hay postulaciones disponibles.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $postulaciones->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar librería SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Puedes agregar scripts adicionales aquí si es necesario
        });
    </script>
</x-app-layout>
