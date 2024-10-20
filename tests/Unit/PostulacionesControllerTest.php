<?php

namespace Tests\Feature;

use App\Models\JobOffer;
use App\Models\User;
use App\Models\JobApplication; // Asegúrate de que este modelo esté importado
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostulacionesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_show_postulaciones_for_an_empresa()
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

        // Autenticación del usuario empresa
        $this->actingAs($empresa);

        // Crear una oferta laboral activa asociada a la empresa
        $jobOffer = JobOffer::factory()->create([
            'empresa_id' => $empresa->id, // Asignar el ID de la empresa
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(10),
        ]);

        // Crear una postulación asociada al postulante y la oferta laboral
        JobApplication::factory()->create([
            'postulante_id' => $postulante->id,
            'job_offer_id' => $jobOffer->id,
            'status' => JobApplication::STATUS_PENDING, // Establecer el estado a Pendiente
        ]);

        // Hacer una solicitud para ver las postulaciones
        $response = $this->get(route('postulaciones.index'));

        // Verificar que la respuesta sea correcta y que la postulación esté en la vista
        $response->assertStatus(200);
        $response->assertViewIs('empresa.postulaciones.index');
        $response->assertViewHas('postulaciones', function ($postulaciones) use ($postulante) {
            return $postulaciones->first()->postulante->id === $postulante->id;
        });
    }

    /** @test */
    public function it_can_filter_postulaciones_by_job_offer_id()
    {
        // Crear un usuario empresa
        $empresa = User::factory()->create([
            'rol' => User::EMPRESA,
            'is_approved' => true,
        ]);

        // Autenticación del usuario empresa
        $this->actingAs($empresa);

        // Crear ofertas laborales
        $jobOffer1 = JobOffer::factory()->create(['empresa_id' => $empresa->id]);
        $jobOffer2 = JobOffer::factory()->create(['empresa_id' => $empresa->id]);

        // Crear postulantes y postulaciones
        $postulante1 = User::factory()->create(['rol' => User::POSTULANTE, 'is_approved' => true]);
        $postulante2 = User::factory()->create(['rol' => User::POSTULANTE, 'is_approved' => true]);

        JobApplication::factory()->create(['postulante_id' => $postulante1->id, 'job_offer_id' => $jobOffer1->id, 'status' => JobApplication::STATUS_PENDING]);
        JobApplication::factory()->create(['postulante_id' => $postulante2->id, 'job_offer_id' => $jobOffer2->id, 'status' => JobApplication::STATUS_PENDING]);

        // Hacer una solicitud para filtrar por una oferta laboral específica
        $response = $this->get(route('postulaciones.index', ['job_offer_id' => $jobOffer1->id]));

        // Verificar que solo se muestren postulaciones de esa oferta laboral
        $response->assertStatus(200);
        $response->assertViewHas('postulaciones', function ($postulaciones) use ($jobOffer1) {
            return $postulaciones->first()->job_offer_id === $jobOffer1->id;
        });
    }

    /** @test */
    public function it_can_search_postulaciones_by_postulante_name_or_email()
    {
        // Crear un usuario empresa
        $empresa = User::factory()->create([
            'rol' => User::EMPRESA,
            'is_approved' => true,
        ]);

        // Autenticación del usuario empresa
        $this->actingAs($empresa);

        // Crear un postulante
        $postulante = User::factory()->create([
            'rol' => User::POSTULANTE,
            'is_approved' => true,
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        // Crear una oferta laboral
        $jobOffer = JobOffer::factory()->create(['empresa_id' => $empresa->id]);

        // Crear una postulación
        JobApplication::factory()->create(['postulante_id' => $postulante->id, 'job_offer_id' => $jobOffer->id, 'status' => JobApplication::STATUS_PENDING]);

        // Hacer una solicitud para buscar por nombre del postulante
        $response = $this->get(route('postulaciones.index', ['search' => 'John']));

        // Verificar que solo se muestren postulaciones que coincidan con la búsqueda
        $response->assertStatus(200);
        $response->assertViewHas('postulaciones', function ($postulaciones) use ($postulante) {
            return $postulaciones->first()->postulante->name === 'John Doe';
        });
    }

    /** @test */
    public function it_can_show_a_specific_job_application()
    {
        // Crear un usuario empresa
        $empresa = User::factory()->create([
            'rol' => User::EMPRESA,
            'is_approved' => true,
        ]);

        // Autenticación del usuario empresa
        $this->actingAs($empresa);

        // Crear un postulante
        $postulante = User::factory()->create(['rol' => User::POSTULANTE, 'is_approved' => true]);

        // Crear una oferta laboral
        $jobOffer = JobOffer::factory()->create(['empresa_id' => $empresa->id]);

        // Crear una postulación
        $jobApplication = JobApplication::factory()->create(['postulante_id' => $postulante->id, 'job_offer_id' => $jobOffer->id, 'status' => JobApplication::STATUS_PENDING]);

        // Hacer una solicitud al método show
        $response = $this->get(route('postulaciones.show', $jobApplication->id));

        // Verificar que la vista sea correcta y que se muestren los detalles de la postulación
        $response->assertStatus(200);
        $response->assertViewIs('empresa.postulaciones.show');
        $response->assertViewHas('application', function ($application) use ($jobApplication) {
            return $application->id === $jobApplication->id;
        });
    }
}
