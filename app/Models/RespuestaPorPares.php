<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaPorPares extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'evaluaciones_por_pares';

    protected $fillable = [
        'usuario_id',
        'evaluado_id',
        'sprint_id',
        'pregunta_id',
        'respuesta',
    ];

    // Relación con Sprint
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    // Relación con Usuario (quien evalúa)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // Relación con Usuario (quien es evaluado)
    public function evaluado()
    {
        return $this->belongsTo(Usuario::class, 'evaluado_id');
    }

    // Relación con Pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }
}
