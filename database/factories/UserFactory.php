<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Encriptar la contraseña
            'remember_token' => Str::random(10),
            'rol' => 3, // Rol por defecto: Postulante
            'dni' => $this->faker->unique()->numerify('########'),
            'ruc' => $this->faker->optional()->numerify('###########'),
            'celular' => $this->faker->optional()->numerify('#########'),
            'archivo_cv' => $this->faker->optional()->fileExtension(), // Archivo CV opcional
            'is_approved' => false, // Campo añadido en la migración
            'current_team_id' => null, // Puede establecerse si hay equipos
            'empresa_id' => null, // Puede establecerse si hay una relación con empresas
            'profile_photo_path' => $this->faker->optional()->imageUrl(), // URL opcional de la foto de perfil
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function administrator(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => User::ADMIN,
        ]);
    }

    public function empresa(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => User::EMPRESA,
        ]);
    }

    public function supervisor(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => User::SUPERVISOR,
        ]);
    }

    public function postulante(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => User::POSTULANTE,
        ]);
    }
}
