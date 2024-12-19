<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPasswordNotification; // Asegúrate de importar esta clase
use App\Models\Result; // Asegúrate de que el modelo Result exista
use App\Models\Rol; // Asegúrate de que el modelo Rol exista

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'usuarios'; // Asegúrate de que el nombre sea correcto

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'carrera',
        'codigoSIS'
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'role_id'); 
    }

    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
    
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'docente_id');
    }

    public function gruposAsignados()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_usuario', 'usuario_id', 'grupo_id');
    }

   
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_usuario', 'usuario_id', 'equipo_id')
                    ->withPivot('rol')
                    ->withTimestamps();
    }
    
    public function avisosCreados()
    {
        return $this->hasMany(Aviso::class, 'docente_id');
    }
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'docente_id');
    }

    public function proyectosCreados()
    {
        return $this->hasMany(Proyecto::class, 'creador_id');
    }

    
}
