<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Supervisores de {{ auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="mb-4 flex items-center justify-between">
                    <a href="{{ route('empresa.supervisores.create') }}" class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">
                        Agregar Supervisor
                    </a>
                </div>

                @if (session('success'))
                    <script>
                        window.addEventListener('DOMContentLoaded', (event) => {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: '{{ session('success') }}',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'top-end'
                            });
                        });
                    </script>
                @endif

                @if ($users->isEmpty())
                    <p>No hay supervisores registrados.</p>
                @else
                    <table class="table-auto w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Nombre</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Email</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-left">DNI</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Celular</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user) <!-- Cambiado $supervisor a $user -->
                                <tr>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white">{{ $user->name }}</td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white">{{ $user->email }}</td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white">{{ $user->dni }}</td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white">{{ $user->celular }}</td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white">
                                        <a href="{{ route('empresa.supervisores.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                                            Editar
                                        </a>
                                        <form action="{{ route('empresa.supervisores.destroy', $user->id) }}" method="POST" class="delete-form" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-button">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Agregar librería SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Confirmación para eliminar supervisor
            document.querySelectorAll('.delete-button').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción eliminará al supervisor.",
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
