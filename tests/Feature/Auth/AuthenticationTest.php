<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;

// Prueba para verificar que la pantalla de inicio de sesión se renderiza correctamente
test('login screen can be rendered', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

// Prueba para autenticar a un usuario utilizando la pantalla de inicio de sesión
test('postulante ingreso correctamente', function () {
    // Crear un usuario con contraseña 'password' y aprobado
    $user = User::factory()->create([
        'password' => Hash::make('password'), // Especificar la contraseña
        'is_approved' => true, // Aprobar el usuario
        'rol' => 3, // Suponiendo que el rol 3 es 'Postulante'
    ]);

    // Intentar iniciar sesión con las credenciales correctas
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password', // Contraseña correcta
    ]);

    // Verificar que el usuario esté autenticado
    $this->assertAuthenticatedAs($user);
    
    // Asegúrate de que esta redirección sea correcta según tu lógica
    $response->assertRedirect('/postulante/perfil'); // Cambia aquí según el rol del usuario
});

test('verificar que no se puede autenticar con una contraseña incorrecta', function () {
    // Crear un usuario con contraseña 'password' y aprobado
    $user = User::factory()->create([
        'password' => Hash::make('password'), // Especificar la contraseña
        'is_approved' => true, // Aprobar el usuario
    ]);

    // Intentar iniciar sesión con una contraseña incorrecta
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password', // Contraseña incorrecta
    ]);

    // Verificar que el usuario no esté autenticado
    $this->assertGuest();
});
