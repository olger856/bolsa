<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Ofertas de Trabajo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="mb-4 flex items-center justify-between">
                    <a href="{{ route('job_offers.create') }}" class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">
                        Crear Nueva Oferta
                    </a>
                </div>

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

                <table class="table-auto w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Título</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Descripción</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Ubicación</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Salario</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Fecha de Inicio</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Fecha de Fin</th>
                            <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobOffers as $offer)
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white">{{ $offer->title }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white">{{ $offer->description }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white">{{ $offer->location }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white">S/{{ number_format($offer->salary, 2) }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white">
                                    {{ $offer->start_date ? \Carbon\Carbon::parse($offer->start_date)->format('d/m/Y H:i') : 'No definida' }}
                                </td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white">
                                    {{ $offer->end_date ? \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y H:i') : 'No definida' }}
                                </td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white">
                                    <a href="{{ route('job_offers.edit', $offer->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                                        Editar
                                    </a>
                                    <form action="{{ route('job_offers.destroy', $offer->id) }}" method="POST" class="delete-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-button">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-2 px-4 text-gray-500">No hay ofertas de trabajo disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-button').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción eliminará la oferta laboral.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('.delete-form').submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
