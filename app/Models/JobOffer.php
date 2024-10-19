<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'empresa_id',
        'location',
        'salary',
        'image',
        'start_date',  // Fecha de inicio
        'end_date',    // Fecha de fin
    ];

    protected $dates = [
        'start_date',  // Añadido para que Eloquent trate este campo como una fecha
        'end_date',    // Añadido para que Eloquent trate este campo como una fecha
    ];
    
    // Relación con el modelo User (empresa)
    public function user()
    {
        return $this->belongsTo(User::class, 'empresa_id');
    }

    // Relación con los postulantes
    public function postulantes()
    {
        return $this->belongsToMany(User::class, 'job_applications', 'job_offer_id', 'postulante_id')
                    ->withPivot('created_at')
                    ->withTimestamps();
    }

    // Método para obtener la URL completa de la imagen
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Relación con las postulaciones
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
