<?php

namespace Database\Factories;

use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'job_offer_id' => JobOffer::factory(),
            'postulante_id' => User::factory(),
            'status' => $this->faker->randomElement(['applied', 'interview', 'hired']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
