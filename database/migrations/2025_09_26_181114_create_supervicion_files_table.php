<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supervision_files', function (Blueprint $table) {
            $table->id();

            // Relación polimórfica (ligará archivos a SupervisionItem)
            $table->morphs('fileable'); // fileable_id, fileable_type

            $table->string('name');
            $table->string('path');
            $table->string('disk')->default('local');
            $table->bigInteger('size')->nullable();
            $table->string('mime_type')->nullable();

            $table->string('descripcion')->nullable();
            $table->enum('aprobado', ['si', 'no'])->default('no');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supervision_files');
    }
};

