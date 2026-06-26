<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pedido: cabecera (quién compró, cuánto, estado)
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'pagado', 'cancelado'])->default('pendiente');
            $table->string('metodo_pago')->default('efectivo'); // efectivo, tarjeta, etc.
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        // Detalle: cada línea del pedido (puede ser curso O producto)
        Schema::create('detalle_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained()->onDelete('cascade');
            $table->enum('item_type', ['curso', 'producto']); // tipo de ítem
            $table->unsignedBigInteger('item_id');             // ID del curso o producto
            $table->string('nombre_item');                     // guardamos el nombre por si cambia
            $table->decimal('precio_unitario', 8, 2);
            $table->integer('cantidad')->default(1);
            $table->decimal('subtotal', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
        Schema::dropIfExists('pedidos');
    }
};
