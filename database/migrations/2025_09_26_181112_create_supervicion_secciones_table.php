<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supervision_secciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('supervision_entidad_registrada_id');
            $table->foreign('supervision_entidad_registrada_id', 'fk_sup_sec_entidad')
                  ->references('id')->on('supervision_entidad_registrada')
                  ->onDelete('cascade');

            $table->string('nombre');                 // Actividades, Programas, Proyecto, Otros
            $table->enum('respuesta', ['si', 'no'])->default('no');
            $table->decimal('promedio', 5, 2)->default(0); // 0–100

            $table->timestamps();

            $table->index('supervision_entidad_registrada_id', 'idx_sup_sec_entidad');
        });
    }

    public function down(): void
    {
        Schema::table('supervision_secciones', function (Blueprint $table) {
            $table->dropForeign('fk_sup_sec_entidad');
            $table->dropIndex('idx_sup_sec_entidad');
        });

        Schema::dropIfExists('supervision_secciones');
    }
};

