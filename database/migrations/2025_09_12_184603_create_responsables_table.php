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
        Schema::create('responsables', function (Blueprint $table) {
            $table->id();

            $table->date('fecha_registro');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dni');
            $table->string('email');
            $table->string('ubigeo');
            $table->string('telefono');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->unsignedBigInteger('id_cargo');
            $table->foreign('id_cargo')->references('id')->on('cargos_responsables');

            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')->references('id')->on('categorias_responsables');

            $table->unsignedBigInteger('id_rol');
            $table->foreign('id_rol')->references('id')->on('roles_responsables');

            $table->unsignedBigInteger('id_departamento')->nullable();
            $table->foreign('id_departamento')->references('id')->on('departamentos');

            $table->unsignedBigInteger('id_provincia')->nullable();
            $table->foreign('id_provincia')->references('id')->on('provincias');

            $table->unsignedBigInteger('id_entidad')->nullable();
            $table->foreign('id_entidad')->references('id')->on('entidades');

            $table->unsignedBigInteger('id_distrito')->nullable();
            $table->foreign('id_distrito')->references('id')->on('distritos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Primero quitar las foreign keys
        Schema::table('responsables', function (Blueprint $table) {
            $table->dropForeign(['id_cargo']);
            $table->dropForeign(['id_categoria']);
            $table->dropForeign(['id_departamento']);
            $table->dropForeign(['id_distrito']);
            $table->dropForeign(['id_provincia']);
            $table->dropForeign(['id_entidad']);
        });

        Schema::dropIfExists('responsables');
    }
};
