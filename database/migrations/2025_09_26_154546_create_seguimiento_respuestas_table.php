<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimiento_respuestas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('seguimiento_id')->constrained('seguimientos');

            // Información de la respuesta
            $table->string('instrumento');                  // nombre del instrumento GRD
            $table->enum('respuesta', ['si', 'no'])->default('no'); // respuesta binaria

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguimiento_respuestas');
    }
};

