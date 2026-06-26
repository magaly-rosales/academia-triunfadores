<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'estado',
        'metodo_pago',
        'transaction_id',
        'notas',
    ];

    // Relación: un pedido pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: un pedido tiene muchas líneas de detalle
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
