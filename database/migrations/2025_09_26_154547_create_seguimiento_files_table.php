<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimiento_files', function (Blueprint $table) {
            $table->id();

            // Relación polimórfica (puede usarse en respuestas u otros)
            $table->morphs('fileable'); // genera fileable_id y fileable_type

            $table->string('name');
            $table->string('path');
            $table->string('disk')->default('local');
            $table->bigInteger('size')->nullable();
            $table->string('mime_type')->nullable();

            // campos específicos de seguimiento
            $table->string('descripcion')->nullable();
            $table->enum('aprobado', ['si', 'no'])->default('no');

            $table->json('extra')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguimiento_files');
    }
};

