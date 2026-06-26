<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'titulo', 'slug', 'resumen', 'contenido',
        'imagen', 'categoria', 'user_id', 'estado', 'publicado_en',
    ];

    protected $casts = [
        'publicado_en' => 'datetime',
    ];

    // Solo posts publicados
    public function scopePublicados($query)
    {
        return $query->where('estado', 'publicado');
    }

    // Genera el slug automáticamente desde el título
    public static function generarSlug(string $titulo): string
    {
        return Str::slug($titulo);
    }

    // Relación: post pertenece a un usuario (autor)
    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
