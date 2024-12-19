<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $table = 'preguntas';

    protected $fillable = [
        'texto', 
        'tipo', 
        'evaluacion', 
        'estado'
    ];

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
}
