<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

    protected $fillable = [
        'codigo',
        'nombre',
        'apellido',
        'edad',
        'curso'
    ];

    public $timestamps = false;
}