<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crear un administrador
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'rol' => User::ADMIN,
            'dni' => '12345678',
            'ruc' => '123456789',
            'celular' => '987654321',
            'archivo_cv' => null,
            'is_approved' => true,
        ]);
    }
}
