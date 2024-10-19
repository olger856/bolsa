<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PostulantJobOfferController extends Controller
{
    // Mostrar todas las ofertas laborales disponibles para los postulantes
    public function index(Request $request)
    {
        // Suponiendo que las ofertas laborales están activas para ser vistas por los postulantes
        $query = JobOffer::where('is_active', true);

        // Si hay un término de búsqueda, filtrar por título
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Obtener todas las ofertas laborales
        $jobOffers = $query->get();

        // Obtener la fecha y hora actual
        $now = Carbon::now();

        // Agregar un atributo a cada oferta para saber si se puede postular
        foreach ($jobOffers as $jobOffer) {
            $jobOffer->canApply = $now->between($jobOffer->start_date, $jobOffer->end_date);
        }

        return view('postulante.job_offers.index', compact('jobOffers'));
    }

    // Aplicar a una oferta laboral
    public function apply(JobOffer $jobOffer)
    {
        $user = Auth::user();

        // Verificar si el usuario es un postulante
        if (!$user->isPostulante()) {
            return redirect()->back()->with('status', 'Solo los postulantes pueden aplicar.');
        }

        // Verificar si la oferta está disponible para postular
        if (!Carbon::now()->between($jobOffer->start_date, $jobOffer->end_date)) {
            return redirect()->back()->with('status', 'La fecha de postulación ha pasado para esta oferta.');
        }

        // Verificar si el postulante ya ha aplicado a esta oferta
        if ($jobOffer->postulantes()->where('postulante_id', $user->id)->exists()) {
            return redirect()->back()->with('status', 'Ya has aplicado a esta oferta.');
        }

        // Asociar al postulante con la oferta laboral
        $jobOffer->postulantes()->attach($user->id);

        return redirect()->back()->with('status', 'Te has postulado correctamente.');
    }

    // Eliminar la postulación de una oferta laboral
    public function unapply(JobOffer $jobOffer)
    {
        $user = Auth::user();

        // Verificar si el usuario es un postulante
        if (!$user->isPostulante()) {
            return redirect()->back()->with('status', 'Solo los postulantes pueden realizar esta acción.');
        }

        // Verificar si el postulante ha aplicado a esta oferta
        if ($jobOffer->postulantes()->where('postulante_id', $user->id)->exists()) {
            // Eliminar la asociación
            $jobOffer->postulantes()->detach($user->id);
            return redirect()->back()->with('status', 'Has eliminado tu postulación.');
        }

        return redirect()->back()->with('status', 'No has aplicado a esta oferta.');
    }

    // Mostrar los detalles de una oferta laboral
    public function show(JobOffer $jobOffer)
    {
        return view('postulante.job_offers.show', compact('jobOffer'));
    }

    // Mostrar las ofertas a las que el postulante ha aplicado
    public function aplicaciones()
    {
        $user = Auth::user();

        // Verificar si el usuario es un postulante
        if (!$user->isPostulante()) {
            return redirect()->back()->with('status', 'Solo los postulantes pueden ver sus aplicaciones.');
        }

        // Obtener las ofertas laborales a las que el usuario ha aplicado
        $jobOffers = $user->jobOffers()->get(); 

        return view('postulante.aplicaciones', compact('jobOffers'));
    }
}
