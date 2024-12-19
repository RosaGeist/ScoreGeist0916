<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles'; // Especificar la tabla si el nombre no sigue la convención

    protected $fillable = [
        'name',
        'description',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'role_id'); // Relación uno a muchos
    }
}

