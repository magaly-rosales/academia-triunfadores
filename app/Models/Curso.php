<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'precio',
        'imagen', 'duracion', 'categoria', 'nivel', 'estado',
    ];

    // Scope para traer solo cursos activos
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
