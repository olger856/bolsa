<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class PostulacionesController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->user()->id;

        // Obtener las ofertas laborales para llenar el dropdown
        $jobOffers = JobOffer::where('empresa_id', $userId)->get(); // Asegúrate de que 'empresa_id' es el campo correcto

        // Crear la consulta base para las postulaciones
        $query = JobApplication::with(['jobOffer', 'postulante'])
            ->whereHas('jobOffer', function($query) use ($userId) {
                $query->where('empresa_id', $userId); // Asegúrate de que esto coincida con el campo en tu BD
            });

        // Filtrar por oferta laboral si se ha seleccionado
        if ($request->has('job_offer_id') && $request->job_offer_id != '') {
            $query->where('job_offer_id', $request->job_offer_id);
        }

        // Búsqueda por nombre o email del postulante si se proporciona
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('postulante', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Obtener las postulaciones, con paginación si lo prefieres
        $postulaciones = $query->paginate(10)->appends($request->all());

        return view('empresa.postulaciones.index', compact('postulaciones', 'jobOffers'));
    }

    public function show($id)
    {
        $userId = auth()->user()->id;

        // Buscar la postulación específica con sus relaciones
        $application = JobApplication::with('jobOffer', 'postulante')
            ->whereHas('jobOffer', function($query) use ($userId) {
                $query->where('empresa_id', $userId); // Asegúrate de que esto coincida
            })
            ->findOrFail($id);

        return view('empresa.postulaciones.show', compact('application'));
    }
}
