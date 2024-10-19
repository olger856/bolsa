<!-- resources/views/admin/supervisores/index.blade.php -->

@extends('layouts.app') <!-- Asegúrate de que tu layout esté correctamente configurado -->

@section('content')
<div class="container">
    <h1>Supervisores</h1>

    <!-- Agregar un enlace para crear nuevos supervisores -->
    <a href="{{ route('admin.supervisores.create') }}" class="btn btn-primary mb-3">Crear Supervisor</a>

    <!-- Tabla de supervisores -->
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supervisores as $supervisor)
                <tr>
                    <td>{{ $supervisor->id }}</td>
                    <td>{{ $supervisor->name }}</td>
                    <td>{{ $supervisor->email }}</td>
                    <td>
                        <!-- Enlaces para editar y eliminar el supervisor -->
                        <a href="{{ route('admin.supervisores.edit', $supervisor) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('admin.supervisores.destroy', $supervisor) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay supervisores registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
