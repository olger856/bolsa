<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Http\Request;

class EmpresaJobOfferController extends Controller
{
    // Mostrar las ofertas laborales de la empresa para crear
    public function showJobOffers()
    {
        $empresa = auth()->user();
        $jobOffers = JobOffer::where('empresa_id', $empresa->id)->get();

        return view('empresa.job_offers.index', compact('jobOffers')); // Vista para crear ofertas
    }

    // Mostrar las postulaciones a las ofertas laborales
    public function showApplications()
    {
        $empresa = auth()->user();
        $jobOffers = JobOffer::where('empresa_id', $empresa->id)->with('postulantes')->get();

        return view('empresa.job_offers.applications', compact('jobOffers')); // Vista para ver aplicaciones
    }

    // Mostrar los postulantes a una oferta laboral específica
    public function showPostulantes(JobOffer $jobOffer)
    {
        $postulantes = $jobOffer->postulantes;

        return view('empresa.job_offers.postulantes', compact('jobOffer', 'postulantes'));
    }

    // Asignar supervisor a un postulante
    public function assignSupervisor(Request $request, JobOffer $jobOffer, User $postulante)
    {
        $supervisorId = $request->input('supervisor_id');
        $postulante->update(['supervisor_id' => $supervisorId]);

        return redirect()->back()->with('status', 'Supervisor asignado correctamente.');
    }
}
