<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('propiedades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_titulo');
            $table->string('tipo'); // casa, depto, terreno, etc.
            $table->string('direccion');
            $table->decimal('precio', 12, 2);
            $table->text('descripcion');
            $table->enum('estado', ['DISPONIBLE', 'RESERVADA', 'VENDIDA']);
            $table->integer('superficie_m2')->nullable();
            $table->integer('ambientes')->nullable();
            $table->unsignedBigInteger('responsable_id');
            $table->foreign('responsable_id')->references('id')->on('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propiedades');
    }
};
