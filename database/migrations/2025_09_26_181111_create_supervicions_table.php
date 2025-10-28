<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supervisions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entidad_id')->constrained('entidades');

            $table->integer('anio');

            // campo para el calculo del promedio final
            $table->decimal('promedio_final', 5, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supervisions');
    }
};
