<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    protected $table = 'equipos';

    protected $fillable = [
        'nombre_empresa',
        'correo_empresa',
        'link_drive',
        'min_personas',
        'max_personas',
        'grupo_id',
        'creador_id',
        'nota'
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id'); // Asegurarse de que la relación esté bien definida
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creador_id');
    }

    public function miembros()
    {
        return $this->belongsToMany(Usuario::class, 'equipo_usuario', 'equipo_id', 'usuario_id')
            ->withPivot('rol')
            ->withTimestamps();
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }
}
