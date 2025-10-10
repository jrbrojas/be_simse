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
        //Schema::disableForeignKeyConstraints();
        //Schema::dropIfExists('departamentos');
        //Schema::dropIfExists('provincias');
        //Schema::dropIfExists('distritos');
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->decimal('latitud', 10, 6)->default(0.0);
            $table->decimal('longitud', 10, 6)->default(0.0);
        });
        Schema::create('provincias', function (Blueprint $table) {
            $table->id();
            $table->string('ubigeo');
            $table->string('codigo');
            $table->string('codigo_departamento');
            $table->string('nombre');
            $table->decimal('latitud', 10, 6)->default(0.0);
            $table->decimal('longitud', 10, 6)->default(0.0);
            $table->foreignId('departamento_id')->constrained('departamentos');
        });
        Schema::create('distritos', function (Blueprint $table) {
            $table->id();
            $table->string('ubigeo');
            $table->string('codigo');
            $table->string('nombre');
            $table->string('iddpto');
            $table->string('idprov');
            $table->foreignId('provincia_id')->constrained('provincias');
            //$table->foreignId('departamento_id')->constrained('departamentos');
        });
        Schema::create('centros_poblados', function (Blueprint $table) {
            $table->id();
            $table->string('ubigeo_distrito');
            $table->string('codigo');
            $table->string('nombre');
            $table->foreignId('distrito_id')->constrained('distritos');
        });
        //Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
