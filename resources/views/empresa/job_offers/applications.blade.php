<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Postulaciones a Mis Ofertas Laborales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Verificación para mostrar la notificación con SweetAlert -->
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

                <!-- Lista de ofertas laborales -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($jobOffers as $offer)
                        <div class="bg-white border rounded-lg overflow-hidden shadow-md relative">
                            <!-- Mostrar imagen si está disponible -->
                            @if ($offer->image)
                                <img src="{{ asset('storage/' . $offer->image) }}" alt="Imagen de la oferta" class="w-full h-48 object-cover">
                            @else
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjg5Wghp2_acyK9UHtIuGUjV9-0uk5Vjzh4A&s" alt="Imagen no disponible" class="w-full h-48 object-cover">
                            @endif

                            <div class="p-6">
                                <h3 class="font-bold text-xl mb-2">{{ $offer->title }}</h3>
                                <p class="text-gray-700 mb-2">Empresa: {{ $offer->user->name ?? 'No disponible' }}</p>
                                <p class="text-gray-700 mb-4">{{ Str::limit($offer->description, 100) }}</p>
                                <p class="text-gray-500">Ubicación: {{ $offer->location ?? 'No especificado' }}</p>
                                <p class="text-gray-500">Salario: S/{{ number_format($offer->salary, 2) }}</p>

                                <!-- Contador de postulantes -->
                                @php
                                    $applicantsCount = $offer->postulantes()->count();
                                @endphp

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="ml-4 flex items-center">
                                        Personas postulando: 
                                        <span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 ml-2 rounded-full border border-gray-300">
                                            {{ $applicantsCount }}
                                        </span>
                                    </span>
                                    <!-- Corregir el enlace de la ruta -->
                                    <a href="{{ route('empresa.job_offers.applications', $offer->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                                        Ver postulaciones
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <!-- Agregar librería SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>
