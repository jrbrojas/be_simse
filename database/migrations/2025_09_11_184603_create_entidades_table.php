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
        Schema::create('entidades', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('ruc')->nullable();
            $table->string('sigla')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('web')->nullable();
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias_responsables');

            $table->string('ubigeo');
            //$table->foreign('ubigeo')->references('ubigeo')->on('distritos');

            $table->string('provincia_id');
            //$table->foreign('provincia_id')->references('idprov')->on('provincias');

            $table->string('departamento_id');
            //$table->foreign('departamento_id')->references('iddpto')->on('departamentos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responsables', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);//, 'departamento_id', 'provincia_id', 'ubigeo']);
        });
        Schema::dropIfExists('entidades');
    }
};
