<?php

use App\Models\Depa;
use App\Models\Prov;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->decimal('latitud', 10, 6)->default(0.0);
            $table->decimal('longitud', 10, 6)->default(0.0);
        });
        Schema::create('provincias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->string('codigo');
            $table->string('nombre');
            $table->decimal('latitud', 10, 6)->default(0.0);
            $table->decimal('longitud', 10, 6)->default(0.0);
        });
        Schema::create('distritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provincia_id')->constrained('provincias');
            $table->string('codigo');
            $table->string('nombre');
        });
        Schema::create('centros_poblados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distrito_id')->constrained('distritos');
            $table->string('codigo');
            $table->string('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamentos');
        Schema::dropIfExists('provincias');
        Schema::dropIfExists('distritos');
        Schema::dropIfExists('centros_poblados');
    }
};
