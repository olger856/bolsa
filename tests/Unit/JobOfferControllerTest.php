<?php

namespace Tests\Feature;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JobOfferControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba que una empresa autenticado puede ver sus ofertas laborales.
     */
    public function test_authenticated_user_can_view_job_offers()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create([
            'rol' => 2, // rol 2 es Empresa
            'is_approved' => true, // Aprobado
        ]);

        // Actuar como el usuario autenticado
        $this->actingAs($user);

        // Crear algunas ofertas laborales asociadas a la empresa
        $jobOffers = JobOffer::factory()->count(3)->create([
            'empresa_id' => $user->id,
        ]);

        // Realizar la solicitud a la ruta de ofertas laborales
        $response = $this->get(route('job_offers.index'));

        // Verifica que la respuesta tiene el estado correcto
        $response->assertStatus(200);

        // Verifica que el usuario está autenticado
        $this->assertAuthenticatedAs($user);

        // Verifica que la respuesta contiene el título de la primera oferta laboral
        $response->assertSee($jobOffers->first()->title);
    }

    /**
     * Prueba que una empresa autenticado puede crear una oferta laboral.
     */
    public function test_authenticated_user_can_create_job_offer()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'rol' => 2,
            'is_approved' => true,
        ]);

        $this->actingAs($user);

        $data = [
            'title' => 'Software Engineer',
            'description' => 'Develop and maintain web applications.',
            'location' => 'Remote',
            'salary' => 5000,
            'start_date' => '2024-09-18',
            'end_date' => '2025-08-11',
            'image' => UploadedFile::fake()->image('car1.jpg'),
        ];

        $response = $this->post(route('job_offers.store'), $data);

        $response->assertRedirect(route('job_offers.index'));
        $this->assertDatabaseHas('job_offers', [
            'title' => 'Software Engineer',
            'empresa_id' => $user->id,
        ]);
    }

    /**
     * Prueba que una empresa autenticado puede actualizar una oferta laboral.
     */
    public function test_authenticated_user_can_update_job_offer()
    {
        $user = User::factory()->create([
            'rol' => 2,
            'is_approved' => true,
        ]);

        $this->actingAs($user);

        $jobOffer = JobOffer::factory()->create([
            'empresa_id' => $user->id,
        ]);

        $data = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'location' => 'Updated location',
            'salary' => 6000,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
        ];

        $response = $this->put(route('job_offers.update', $jobOffer), $data);

        $response->assertRedirect(route('job_offers.index'));
        $this->assertDatabaseHas('job_offers', [
            'id' => $jobOffer->id,
            'title' => 'Updated Title',
            'description' => 'Updated description',
        ]);
    }

    /**
     * Prueba que una empresa autenticado puede eliminar una oferta laboral.
     */
    public function test_authenticated_user_can_delete_job_offer()
    {
        $user = User::factory()->create([
            'rol' => 2,
            'is_approved' => true,
        ]);

        $this->actingAs($user);

        $jobOffer = JobOffer::factory()->create([
            'empresa_id' => $user->id,
        ]);

        $this->assertDatabaseHas('job_offers', [
            'id' => $jobOffer->id,
        ]);

        $response = $this->delete(route('job_offers.destroy', $jobOffer));

        $response->assertRedirect(route('job_offers.index'));
        $this->assertDatabaseMissing('job_offers', ['id' => $jobOffer->id]);
    }
}
