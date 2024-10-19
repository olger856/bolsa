<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis postulaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if(session('status'))
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

                @if($jobOffers->isEmpty())
                    <div class="alert alert-warning">
                        No has aplicado a ninguna oferta laboral.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($jobOffers as $jobOffer)
                            <div class="bg-white border rounded-lg overflow-hidden shadow-md p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100">
                                        @if($jobOffer->user->profile_photo_path)
                                            <img src="{{ Storage::url($jobOffer->user->profile_photo_path) }}" alt="Logo de la empresa" class="object-cover w-full h-full">
                                        @else
                                            <img src="https://via.placeholder.com/150" alt="Sin imagen" class="object-cover w-full h-full">
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-lg font-semibold">{{ $jobOffer->user->name }}</p>
                                    </div>
                                </div>

                                <h5 class="font-bold text-xl mb-2">{{ $jobOffer->title }}</h5>
                                <p class="text-gray-700 mb-2">{{ Str::limit($jobOffer->description, 100) }}</p>
                                <p><strong>Ubicación:</strong> {{ $jobOffer->location }}</p>
                                <p><strong>Salario:</strong> S/{{ number_format($jobOffer->salary, 2) }}</p>

                                <!-- Mostrar la fecha de postulación -->
                                @if($jobOffer->postulantes->contains(Auth::user()->id))
                                    <p class="text-sm text-gray-500 mt-2">
                                        <strong>Postulado el:</strong>
                                        {{ $jobOffer->postulantes->firstWhere('id', Auth::id())->pivot->created_at->format('d/m/Y H:i') }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-500 mt-2">
                                        <strong>Estado:</strong> No has postulado a esta oferta.
                                    </p>
                                @endif

                                <div class="mt-4 flex justify-between">
                                    <form action="{{ route('postulante.unapply', $jobOffer) }}" method="POST" class="inline unapply-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md unapply-button">
                                            Eliminar Postulación
                                        </button>
                                    </form>

                                    <a href="{{ route('postulante.job_offers.show', $jobOffer) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
