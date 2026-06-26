<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    protected $fillable = [
        'user_id', 'item_type', 'item_id', 'nombre_item',
        'precio', 'imagen', 'cantidad',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}