<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Roles de usuario
    const ADMIN = 1;
    const EMPRESA = 2;
    const POSTULANTE = 3;
    const SUPERVISOR = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'dni',
        'ruc',
        'email',
        'celular',
        'rol',
        'username',
        'password',
        'archivo_cv',
        'is_approved',
        'profile_photo_path', // Agregado para foto de perfil
        'empresa_id', // Agregado para relación con empresa
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Métodos para verificar el rol del usuario
    public function isAdmin()
    {
        return $this->rol === self::ADMIN;
    }

    public function isEmpresa()
    {
        return $this->rol === self::EMPRESA;
    }

    public function isPostulante()
    {
        return $this->rol === self::POSTULANTE;
    }

    public function isSupervisor()
    {
        return $this->rol === self::SUPERVISOR;
    }

    /**
     * Obtener el nombre del rol del usuario.
     *
     * @return string
     */
    public function getRoleName()
    {
        switch ($this->rol) {
            case self::ADMIN:
                return 'Administrador';
            case self::EMPRESA:
                return 'Empresa';
            case self::POSTULANTE:
                return 'Postulante';
            case self::SUPERVISOR:
                return 'Supervisor';
            default:
                return 'Desconocido';
        }
    }

    // Relación con la empresa (si el usuario está asociado a una empresa)
    public function empresa()
    {
        return $this->belongsTo(User::class, 'empresa_id'); // Definir relación con la empresa
    }

    // Relación con las ofertas laborales a las que el postulante ha aplicado
    public function jobOffers()
    {
        return $this->belongsToMany(JobOffer::class, 'job_applications', 'postulante_id', 'job_offer_id');
    }

    // Relación para las ofertas a las que el usuario ha aplicado
    public function appliedOffers()
    {
        return $this->belongsToMany(JobOffer::class, 'job_applications', 'postulante_id', 'job_offer_id')
                    ->withPivot('created_at') // Asegura que se pueda acceder a la fecha de postulación
                    ->withTimestamps(); // Para guardar las marcas de tiempo
    }

    // Método para subir la imagen de perfil
    public function uploadProfilePhoto($photo)
    {
        $path = $photo->store('profile_photos', 'public'); // Ajusta el disco según tu configuración
        $this->profile_photo_path = $path;
        $this->save();
    }

    // Relación con las postulaciones como postulante
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'postulante_id');
    }

    // Relación con las ofertas laborales creadas por la empresa
    public function createdJobOffers()
    {
        return $this->hasMany(JobOffer::class, 'empresa_id'); // Relación de la empresa con sus ofertas laborales
    }

    // Relación con las postulaciones recibidas por la empresa a través de sus ofertas laborales
    public function receivedJobApplications()
    {
        return $this->hasManyThrough(JobApplication::class, JobOffer::class, 'empresa_id', 'job_offer_id');
    }

    // Método para obtener las fechas de las postulaciones del postulante
    public function applicationDates()
    {
        return $this->hasMany(JobApplication::class, 'postulante_id')->select('created_at');
    }
}
