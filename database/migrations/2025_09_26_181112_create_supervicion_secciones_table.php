<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supervision_respuestas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supervision_id')->constrained('supervisions');

            $table->string('nombre');                 // Actividades, Programas, Proyecto, Otros
            $table->enum('respuesta', ['si', 'no'])->default('no');
            $table->decimal('promedio', 5, 2)->default(0); // 0–100

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supervision_respuestas');
    }
};

