<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'precio',
        'imagen', 'stock', 'categoria', 'estado',
    ];

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    // Verifica si hay stock disponible
    public function tieneStock(): bool
    {
        return $this->stock > 0;
    }
}
