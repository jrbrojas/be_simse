<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supervision_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('supervision_seccion_id');
            $table->foreign('supervision_seccion_id', 'fk_sup_item_seccion')
                  ->references('id')->on('supervision_secciones')
                  ->onDelete('cascade');

            $table->string('nombre');                        // Ej: “Taller X”
            $table->decimal('porcentaje', 5, 2)->default(0); // 0–100
            //$table->enum('respuesta', ['si', 'no'])->default('no');
            //$table->text('observacion')->nullable();
            $table->timestamps();

            $table->index('supervision_seccion_id', 'idx_sup_item_seccion');
        });
    }

    public function down(): void
    {
        Schema::table('supervision_items', function (Blueprint $table) {
            $table->dropForeign('fk_sup_item_seccion');
            $table->dropIndex('idx_sup_item_seccion');
        });

        Schema::dropIfExists('supervision_items');
    }
};
