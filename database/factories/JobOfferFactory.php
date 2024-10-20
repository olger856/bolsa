<?php

namespace Database\Factories;

use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobOfferFactory extends Factory
{
    protected $model = JobOffer::class;

    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'salary' => $this->faker->numberBetween(1000, 10000),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'empresa_id' => null, // Esto lo asignarás en tus pruebas para relacionarlo con el usuario empresa
            'image' => $this->faker->imageUrl(), // Si tienes una columna de imagen
        ];
    }
}
