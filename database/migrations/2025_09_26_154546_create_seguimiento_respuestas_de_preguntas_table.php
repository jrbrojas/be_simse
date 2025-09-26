<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimiento_respuestas_preguntas', function (Blueprint $table) {
            $table->id();

            // Relación con la entidad registrada
            $table->unsignedBigInteger('seguimiento_entidad_registrada_id');
            $table->foreign('seguimiento_entidad_registrada_id')
                  ->references('id')
                  ->on('seguimiento_entidad_registrada')
                  ->onDelete('cascade');

            // Información de la respuesta
            $table->string('instrumento');                  // nombre del instrumento GRD
            $table->enum('respuesta', ['si', 'no'])->default('no'); // respuesta binaria
            $table->boolean('aprobado')->default(false);     // si el instrumento fue aprobado
            $table->text('observacion')->nullable();         // detalle opcional de la respuesta

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('seguimiento_respuestas_preguntas', function (Blueprint $table) {
            $table->dropForeign(['seguimiento_entidad_registrada_id']);
        });

        Schema::dropIfExists('seguimiento_respuestas_preguntas');
    }
};

