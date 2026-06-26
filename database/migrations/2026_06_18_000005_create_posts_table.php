<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();       // URL amigable: "mi-primer-post"
            $table->text('resumen')->nullable();    // texto corto para la lista
            $table->longText('contenido');          // cuerpo completo del post
            $table->string('imagen')->nullable();   // imagen de portada
            $table->string('categoria')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // quién lo escribió
            $table->enum('estado', ['borrador', 'publicado'])->default('borrador');
            $table->timestamp('publicado_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
