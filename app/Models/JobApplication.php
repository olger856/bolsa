<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados de manera masiva
    protected $fillable = [
        'job_offer_id',
        'postulante_id', // Este campo debe existir en la tabla 'job_applications'
        'status',
    ];

    /**
     * Relación con la oferta laboral (JobOffer).
     * Cada postulación pertenece a una oferta de trabajo.
     */
    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class, 'job_offer_id');
    }

    /**
     * Relación con el postulante (User).
     * Cada postulación pertenece a un postulante.
     */
    public function postulante() // Debe coincidir con este nombre
    {
        return $this->belongsTo(User::class, 'postulante_id'); // Asegúrate de que 'postulante_id' sea el nombre correcto del campo en la tabla
    }
}
