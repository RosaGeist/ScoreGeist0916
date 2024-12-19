<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;

    
    protected $table = 'sprints';

    protected $fillable = [
        'nombre',
        'objetivo',
        'fecha_inicio',
        'fecha_fin',
        'proyecto_id', 
        'estado'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class); // Relación con el modelo Proyecto
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
    public function historias()
    {
        return $this->hasMany(HistoriaUsuario::class, 'sprints_id');
    }
    
}
