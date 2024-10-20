<?php

namespace Tests\Feature;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostulantJobOfferControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_show_available_job_offers()
    {
        // Crear un usuario empresa
        $empresa = User::factory()->create([
            'rol' => User::EMPRESA,
            'is_approved' => true,
        ]);

        // Crear un usuario postulante
        $postulante = User::factory()->create([
            'rol' => User::POSTULANTE,
            'is_approved' => true,
        ]);

        // Autenticación del usuario postulante
        $this->actingAs($postulante);

        // Crear una oferta laboral activa asociada a la empresa
        $jobOffer = JobOffer::factory()->create([
            'empresa_id' => $empresa->id, // Asignar el ID de la empresa
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(10),
        ]);

        // Hacer una solicitud para ver las ofertas laborales
        $response = $this->get(route('postulante.job_offers.index'));

        // Verificar que la respuesta sea correcta y que la oferta esté en la vista
        $response->assertStatus(200);
        $response->assertSee($jobOffer->title);
    }

    /** @test */
    public function it_can_apply_to_job_offer()
    {
        // Crear un usuario empresa
        $empresa = User::factory()->create([
            'rol' => User::EMPRESA,
            'is_approved' => true,
        ]);

        // Crear un usuario postulante
        $postulante = User::factory()->create([
            'rol' => User::POSTULANTE,
            'is_approved' => true,
        ]);

        // Autenticación del usuario postulante
        $this->actingAs($postulante);

        // Crear una oferta laboral asociada a la empresa
        $jobOffer = JobOffer::factory()->create([
            'empresa_id' => $empresa->id, // Asignar el ID de la empresa
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(10),
        ]);

        // Hacer una solicitud para aplicar a la oferta
        $response = $this->post(route('job_offers.apply', $jobOffer));

        // Verificar que el postulante fue redirigido correctamente
        $response->assertRedirect();
        $this->assertDatabaseHas('job_applications', [
            'postulante_id' => $postulante->id,
            'job_offer_id' => $jobOffer->id,
        ]);
        $response->assertSessionHas('status', 'Te has postulado correctamente.');
    }

    /** @test */
    public function it_can_unapply_from_job_offer()
    {
        // Crear un usuario empresa
        $empresa = User::factory()->create([
            'rol' => User::EMPRESA,
            'is_approved' => true,
        ]);

        // Crear un usuario postulante
        $postulante = User::factory()->create([
            'rol' => User::POSTULANTE,
            'is_approved' => true,
        ]);

        // Autenticación del usuario postulante
        $this->actingAs($postulante);

        // Crear una oferta laboral asociada a la empresa
        $jobOffer = JobOffer::factory()->create([
            'empresa_id' => $empresa->id, // Asignar el ID de la empresa
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(10),
        ]);

        // Hacer que el usuario se postule a la oferta
        $jobOffer->postulantes()->attach($postulante->id);

        // Hacer una solicitud para deshacer la postulación
        $response = $this->delete(route('postulante.unapply', $jobOffer));

        // Verificar que el postulante fue redirigido correctamente
        $response->assertRedirect();
        $this->assertDatabaseMissing('job_applications', [
            'postulante_id' => $postulante->id,
            'job_offer_id' => $jobOffer->id,
        ]);
        $response->assertSessionHas('status', 'Has eliminado tu postulación.');
    }

    /** @test */
    public function it_can_show_applied_job_offers()
    {
        // Crear un usuario empresa
        $empresa = User::factory()->create([
            'rol' => User::EMPRESA,
            'is_approved' => true,
        ]);

        // Crear un usuario postulante
        $postulante = User::factory()->create([
            'rol' => User::POSTULANTE,
            'is_approved' => true,
        ]);

        // Autenticación del usuario postulante
        $this->actingAs($postulante);

        // Crear una oferta laboral asociada a la empresa
        $jobOffer = JobOffer::factory()->create([
            'empresa_id' => $empresa->id, // Asignar el ID de la empresa
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(10),
        ]);

        // Hacer que el usuario se postule a la oferta
        $jobOffer->postulantes()->attach($postulante->id);

        // Hacer una solicitud para ver las aplicaciones
        $response = $this->get(route('postulante.aplicaciones'));

        // Verificar que la respuesta sea correcta y que la oferta aplicada esté en la vista
        $response->assertStatus(200);
        $response->assertSee($jobOffer->title);
    }
}
