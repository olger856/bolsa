<?php

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Prueba para renderizar la pantalla de registro
test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

// Prueba para registrar un nuevo postulante
test('new postulante can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test Postulante',
        'email' => 'postulante@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'rol' => 3, // Rol para Postulante
    ]);

    // Verificar que el registro redirige correctamente y muestra el mensaje de confirmación
    $response->assertSessionHas('status', 'Tu solicitud de registro ha sido enviada. Espera la aprobación del administrador.');
    $response->assertRedirect('/register'); // Ya que aún no está aprobado

    // Verificar que el usuario fue creado en la base de datos con el rol de postulante
    $this->assertDatabaseHas('users', [
        'email' => 'postulante@example.com',
        'rol' => 3,
        'is_approved' => false, // Aún no aprobado
    ]);

    // Simular la aprobación automática para los tests
    $user = User::where('email', 'postulante@example.com')->first();
    $user->is_approved = 1; // Aprobar usuario
    $user->save();

    // Autenticar manualmente al usuario aprobado
    $this->actingAs($user);

    // Verificar que el usuario está autenticado y redirigir a la página de inicio
    $this->assertAuthenticated();
    $this->get(RouteServiceProvider::HOME)->assertStatus(200);
});

// Prueba para registrar una nueva empresa con campos adicionales
test('new empresa can register with additional fields', function () {
    $response = $this->post('/register', [
        'name' => 'Test Empresa',
        'email' => 'empresa@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'rol' => 2,
        'ruc' => '12345678901',
        'celular' => '987654321',
    ]);

    // Verificar que el registro redirige correctamente y muestra el mensaje de confirmación
    $response->assertSessionHas('status', 'Tu solicitud de registro ha sido enviada. Espera la aprobación del administrador.');
    $response->assertRedirect('/register'); // Ya que aún no está aprobado

    // Verificar que el usuario fue creado en la base de datos con los campos adicionales
    $this->assertDatabaseHas('users', [
        'email' => 'empresa@example.com',
        'rol' => 2,
        'ruc' => '12345678901',
        'celular' => '987654321',
        'is_approved' => false, // Aún no aprobado
    ]);

    // Simular la aprobación automática para los tests
    $user = User::where('email', 'empresa@example.com')->first();
    $user->is_approved = 1; // Aprobar usuario
    $user->save();

    // Autenticar manualmente al usuario aprobado
    $this->actingAs($user);

    // Verificar que el usuario está autenticado y redirigir a la página de inicio
    $this->assertAuthenticated();
    $this->get(RouteServiceProvider::HOME)->assertStatus(200);
});

// Prueba para validar campos obligatorios en el registro
test('registration requires mandatory fields', function () {
    $response = $this->post('/register', [
        'name' => '', // Campo vacío
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ]);

    // Verificar que la respuesta tenga errores de validación para los campos obligatorios
    $response->assertSessionHasErrors(['name', 'email', 'password']);
});
