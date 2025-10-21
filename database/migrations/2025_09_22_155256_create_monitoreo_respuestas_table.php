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
        Schema::create('monitoreo_respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoreo_id')->constrained('monitoreos');

            $table->string('codigo');
            $table->string('op');
            $table->string('titulo');
            $table->string('pregunta');
            $table->string('type');

            $table->string('respuesta')->default('no');
            $table->integer('cantidad_evidencias');
            $table->integer('porcentaje');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoreo_respuestas');
    }
};
