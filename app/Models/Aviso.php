<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $table = 'avisos';
    
    protected $fillable = [
        'grupo_id',
        'docente_id',
        'titulo',
        'contenido',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function docente()
    {
        return $this->belongsTo(Usuario::class, 'docente_id');
    }
}
