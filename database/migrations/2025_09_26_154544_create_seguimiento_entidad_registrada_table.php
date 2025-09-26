<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimiento_entidad_registrada', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('entidad_id');
            $table->foreign('entidad_id')->references('id')->on('entidades');

            $table->unsignedBigInteger('categoria_responsable_id');
            $table->foreign('categoria_responsable_id')->references('id')->on('categorias_responsables');

            $table->string('ubigeo');
            $table->string('provincia_idprov');
            $table->string('departamento_iddpto');
            $table->integer('anio');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('seguimiento_entidad_registrada', function (Blueprint $table) {
            $table->dropForeign(['entidad_id']);
            $table->dropForeign(['categoria_responsable_id']);
        });
        Schema::dropIfExists('seguimiento_entidad_registrada');
    }
};
