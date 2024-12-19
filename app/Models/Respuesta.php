<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;
    protected $table = 'respuestas';

    protected $fillable = [
        'sprint_id',
        'usuario_id',
        'pregunta_id',
        'respuesta',
    ];

    // Relación con Sprint
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // Relación con Pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }
}
