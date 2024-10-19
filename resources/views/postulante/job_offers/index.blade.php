<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ofertas de Trabajo Disponibles') }}
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

                <!-- Formulario de búsqueda -->
                <form action="{{ route('postulante.job_offers.index') }}" method="GET" class="mb-4">
                    <input type="text" name="search" placeholder="Buscar por título" class="border px-4 py-2 rounded-md" />
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Buscar</button>
                </form>

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

                                <div class="mt-4 flex items-center justify-between">
                                    @php
                                        $applied = $offer->postulantes()->where('postulante_id', auth()->user()->id)->exists();
                                        $applicantsCount = $offer->postulantes()->count();
                                        $canApply = \Carbon\Carbon::now()->between($offer->start_date, $offer->end_date);
                                        $hasNotStarted = \Carbon\Carbon::now()->isBefore($offer->start_date);
                                    @endphp

                                    <div class="flex items-center">
                                        @if ($applied)
                                            <span class="absolute top-0 right-0 bg-green-600 text-white text-sm px-2 py-1 rounded-bl-lg">
                                                Ya postulaste a esta oferta laboral
                                            </span>
                                            <form action="{{ route('job_offers.unapply', $offer->id) }}" method="POST" class="inline unapply-form">
                                                @csrf
                                                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md mt-2 unapply-button">
                                                    Eliminar Postulación
                                                </button>
                                            </form>
                                        @else
                                            @if ($canApply)
                                                <form action="{{ route('job_offers.apply', $offer->id) }}" method="POST" class="apply-form">
                                                    @csrf
                                                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2 apply-button">
                                                        Postular
                                                    </button>
                                                </form>
                                            @elseif ($hasNotStarted)
                                                <span class="text-orange-500">La fecha de postulación aún no ha comenzado.</span>
                                            @else
                                                <span class="text-red-500">La fecha de postulación ha pasado para esta oferta.</span>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Contador de postulantes con borde y alineado a la derecha -->
                                    <span class="ml-4 flex items-center">
                                        Personas postulando: 
                                        <span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 ml-2 rounded-full border border-gray-300">
                                            {{ $applicantsCount }}
                                        </span>
                                    </span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Confirmación para Postulación
            document.querySelectorAll('.apply-button').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¿Quieres postular a esta oferta?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, postularme',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('.apply-form').submit();
                        }
                    });
                });
            });

            // Confirmación para Eliminar Postulación
            document.querySelectorAll('.unapply-button').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esto eliminará tu postulación.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('.unapply-form').submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
