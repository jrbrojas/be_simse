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
        Schema::create('monitoreos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entidad_id')->constrained('entidades');

            $table->integer('anio');

            // informacion general
            $table->string('que_implementa');
            $table->string('sustento');
            $table->integer('n_personas_en_la_instancia');
            $table->integer('n_personas_grd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoreos');
    }
};
