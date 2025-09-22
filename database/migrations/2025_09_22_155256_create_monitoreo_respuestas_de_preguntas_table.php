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
        Schema::create('monitoreo_respuestas_de_preguntas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('monitoreo_entidad_registrada_id');
            $table->foreign('monitoreo_entidad_registrada_id')->references('id')->on('monitoreo_entidad_registrada');

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
        Schema::table('monitoreo_respuestas_de_preguntas', function (Blueprint $table) {
            $table->dropForeign('monitoreo_entidad_registrada_id');
        });
        Schema::dropIfExists('monitoreo_respuestas_de_preguntas');
    }
};
