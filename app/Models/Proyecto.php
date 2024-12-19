<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'objetivos',
        'duracion_inicio',
        'duracion_fin',
        'estado',
        'equipo_id',
        'creador_id',
    ];

    // Relación con el equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    // Relación con el creador (usuario)
    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creador_id');
    }

    public function sprints()
{
    return $this->hasMany(Sprint::class, 'proyecto_id');
}


}