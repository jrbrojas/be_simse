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
        Schema::create('directorio_entidad', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_registro');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias_responsables');

            $table->unsignedBigInteger('entidad_id');
            $table->foreign('entidad_id')->references('id')->on('entidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directorio_entidad');
    }
};
