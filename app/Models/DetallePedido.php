<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedido';

    protected $fillable = [
        'pedido_id', 'item_type', 'item_id',
        'nombre_item', 'precio_unitario', 'cantidad', 'subtotal',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Devuelve el modelo real (Curso o Producto) según item_type
    public function item()
    {
        if ($this->item_type === 'curso') {
            return Curso::find($this->item_id);
        }
        return Producto::find($this->item_id);
    }
}
