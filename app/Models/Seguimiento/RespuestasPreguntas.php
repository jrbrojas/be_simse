<?php

namespace App\Models\Seguimiento;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RespuestasPreguntas extends Model
{
    protected $table = 'seguimiento_respuestas_preguntas';

    protected $fillable = [
        'seguimiento_entidad_registrada_id',
        'instrumento',
        'respuesta',
        'aprobado',
        'observacion',
    ];

    public function entidadRegistrada()
    {
        return $this->belongsTo(EntidadRegistrada::class, 'seguimiento_entidad_registrada_id');
    }

    /**
     * Relación con archivos adjuntos
     * @return MorphMany<File>
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}

