<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Postulantes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-4 flex items-center justify-between">
                        <!-- Botón para crear postulantes -->
                        <a href="{{ route('admin.users.create') }}" class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">Crear Postulante</a>

                        <!-- Notificación de aprobación pendiente -->
                        <div>
                            @if($pendingApprovalCount > 0)
                                <a href="{{ route('usuarios.no.aprobados') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                    Aprobar Postulantes
                                    <span class="ml-2 bg-red-700 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingApprovalCount }}</span>
                                </a>
                            @else
                                <span class="text-gray-500">No hay postulantes pendientes de aprobación</span>
                            @endif
                        </div>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">ID</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Nombre</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">DNI</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Correo</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Rol</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Estado de Aprobación</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">CV</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $user->id }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $user->name }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $user->dni }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $user->email }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $user->getRoleName() }}</td>
                                <td class="border px-4 py-2 text-center">
                                    @if ($user->is_approved)
                                        <span class="bg-green-500 text-white px-2 py-1 rounded">Aprobado</span>
                                    @else
                                        <span class="bg-yellow-500 text-white px-2 py-1 rounded">No Aprobado</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    @if ($user->archivo_cv)
                                        <a href="{{ asset('storage/' . $user->archivo_cv) }}" target="_blank" class="text-blue-600 dark:text-blue-400">Ver CV</a>
                                    @else
                                        No disponible
                                    @endif
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <div class="flex justify-center">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-2 px-4 rounded mr-2">Editar</a>

                                        <!-- SweetAlert para confirmación de eliminación -->
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-2 px-4 rounded delete-button">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar librería SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Confirmación para eliminar postulante
            document.querySelectorAll('.delete-button').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción eliminará al postulante.",
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
