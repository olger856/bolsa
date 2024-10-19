<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios No Aprobados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4 flex space-x-2">
                    <button id="showPostulantes" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-150">Postulantes</button>
                    <button id="showEmpresas" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-150">Empresas</button>
                    <button id="showAll" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-150">Mostrar Todos</button>
                </div>

                <h3 id="tableHeader" class="font-semibold text-lg text-gray-800 mb-4">Usuarios No Aprobados</h3>
                <table id="usuariosTable" class="min-w-full divide-y divide-gray-200 mb-6">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($usuarios as $usuario)
                            <tr class="usuario-row" data-rol="{{ $usuario->rol }}">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('users.toggleApproval', $usuario->id) }}" method="POST" class="inline toggle-approval-form">
                                        @csrf
                                        @method('POST')
                                        <button type="button" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-150 approval-button" data-username="{{ $usuario->name }}">
                                            Aprobar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const showPostulantesButton = document.getElementById('showPostulantes');
            const showEmpresasButton = document.getElementById('showEmpresas');
            const showAllButton = document.getElementById('showAll');
            const usuarioRows = document.querySelectorAll('.usuario-row');
            const tableHeader = document.getElementById('tableHeader');

            // Filtros de usuarios
            showPostulantesButton.addEventListener('click', function () {
                usuarioRows.forEach(row => {
                    row.style.display = row.getAttribute('data-rol') == 3 ? '' : 'none'; // Mostrar postulantes
                });
                tableHeader.textContent = 'Postulantes No Aprobados';
            });

            showEmpresasButton.addEventListener('click', function () {
                usuarioRows.forEach(row => {
                    row.style.display = row.getAttribute('data-rol') == 2 ? '' : 'none'; // Mostrar empresas
                });
                tableHeader.textContent = 'Empresas No Aprobadas';
            });

            showAllButton.addEventListener('click', function () {
                usuarioRows.forEach(row => {
                    row.style.display = ''; // Mostrar todos
                });
                tableHeader.textContent = 'Usuarios No Aprobados';
            });

            // Confirmación de aprobación
            document.querySelectorAll('.approval-button').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('.toggle-approval-form');
                    const action = form.getAttribute('action');
                    const username = this.getAttribute('data-username');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `¿Quieres aprobar a ${username}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, aprobar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
