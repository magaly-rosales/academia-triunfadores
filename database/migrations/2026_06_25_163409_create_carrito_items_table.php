<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('item_type', ['curso', 'producto']);
            $table->unsignedBigInteger('item_id');
            $table->string('nombre_item');
            $table->decimal('precio', 8, 2);
            $table->string('imagen')->nullable();
            $table->integer('cantidad')->default(1);
            $table->timestamps();

            // Un usuario no puede tener duplicado el mismo curso/producto
            $table->unique(['user_id', 'item_type', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrito_items');
    }
};