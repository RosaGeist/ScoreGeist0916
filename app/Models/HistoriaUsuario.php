<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaUsuario extends Model
{
    use HasFactory;
    protected $table = 'historias_de_usuario';

    protected $fillable = [
        'titulo',
        'descripcion',
        'sprints_id',
        'prioridad',
        'estado',
        'criterios_aceptacion'
    ];

    public function sprint()
    {
        return $this->belongsTo(Sprint::class, 'sprints_id');
    }

    public function subtareas()
    {
        return $this->hasMany(Subtarea::class);
    }
}
