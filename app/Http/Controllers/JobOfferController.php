<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Asegúrate de importar Carbon

class JobOfferController extends Controller
{
    // Listar todas las ofertas laborales de la empresa autenticada
    public function index()
    {
        $jobOffers = JobOffer::where('empresa_id', Auth::id())->get();
        return view('empresa.job_offers.index', compact('jobOffers'));
    }

    // Mostrar el formulario para crear una nueva oferta
    public function create()
    {
        return view('empresa.job_offers.create');
    }

    // Guardar una nueva oferta laboral
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'required|date', // Permite cualquier fecha
            'end_date' => 'required|date|after_or_equal:start_date',  // La fecha de fin debe ser igual o posterior a la de inicio
        ]);

        // Debug: Ver los valores recibidos para las fechas
        \Log::info('Start Date: ', ['start_date' => $request->start_date]);
        \Log::info('End Date: ', ['end_date' => $request->end_date]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('job_offers', 'public');
        }

        JobOffer::create([
            'title' => $request->title,
            'description' => $request->description,
            'empresa_id' => Auth::id(),
            'location' => $request->location,
            'salary' => $request->salary,
            'image' => $imagePath,
            'start_date' => Carbon::parse($request->start_date),  // Almacenar la fecha de inicio
            'end_date' => Carbon::parse($request->end_date),      // Almacenar la fecha de fin
        ]);

        return redirect()->route('job_offers.index')->with('status', 'Oferta de trabajo creada exitosamente.');
    }

    // Mostrar el formulario para editar una oferta laboral existente
    public function edit(JobOffer $jobOffer)
    {
        return view('empresa.job_offers.edit', compact('jobOffer'));
    }

    // Actualizar una oferta laboral existente
    public function update(Request $request, JobOffer $jobOffer)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'required|date', // Permite cualquier fecha
            'end_date' => 'required|date|after_or_equal:start_date',  // La fecha de fin debe ser igual o posterior a la de inicio
        ]);

        $data = $request->only(['title', 'description', 'location', 'salary']);

        // Convertir las fechas a formato Carbon
        $data['start_date'] = Carbon::parse($request->start_date);
        $data['end_date'] = Carbon::parse($request->end_date);

        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($jobOffer->image) {
                Storage::disk('public')->delete($jobOffer->image);
            }
            $imagePath = $request->file('image')->store('job_offers', 'public');
            $data['image'] = $imagePath;
        }

        $jobOffer->update($data);

        return redirect()->route('job_offers.index')->with('status', 'Oferta de trabajo actualizada exitosamente.');
    }

    // Eliminar una oferta laboral
    public function destroy(JobOffer $jobOffer)
    {
        // Eliminar la imagen si existe
        if ($jobOffer->image) {
            Storage::disk('public')->delete($jobOffer->image);
        }

        $jobOffer->delete();
        return redirect()->route('job_offers.index')->with('status', 'Oferta de trabajo eliminada exitosamente.');
    }

    // Aplicar a una oferta laboral (solo para postulantes)
    public function apply(JobOffer $jobOffer)
    {
        $user = Auth::user();

        // Verificar si el usuario es postulante
        if (!$user->isPostulante()) {
            return redirect()->back()->with('status', 'Solo los postulantes pueden aplicar.');
        }

        // Verificar si ya ha aplicado a la oferta
        if ($jobOffer->postulantes()->where('postulante_id', $user->id)->exists()) {
            return redirect()->back()->with('status', 'Ya has aplicado a esta oferta.');
        }

        // Crear una nueva postulación en la tabla job_applications
        JobApplication::create([
            'job_offer_id' => $jobOffer->id,
            'postulante_id' => $user->id,
            'status' => 1, // Estado "Pendiente"
        ]);

        return redirect()->back()->with('status', 'Te has postulado correctamente.');
    }

    // Mostrar las postulaciones (aplicaciones) a ofertas laborales
    public function showApplications()
    {
        // Obtener todas las aplicaciones a las ofertas de la empresa autenticada
        $applications = JobApplication::with(['postulante', 'jobOffer'])
            ->whereHas('jobOffer', function ($query) {
                $query->where('empresa_id', Auth::id());
            })
            ->get();

        return view('empresa.postulaciones.index', compact('applications'));
    }
}
