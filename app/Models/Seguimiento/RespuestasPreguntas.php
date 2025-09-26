<?php

namespace App\Models\Seguimiento;

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
     * @return MorphMany<SeguimientoFile>
     */
    public function files()
    {
        return $this->morphMany(SeguimientoFile::class, 'fileable');
    }
}

