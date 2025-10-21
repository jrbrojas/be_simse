<?php

namespace App\Models\Seguimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SeguimientoRespuesta extends Model
{
    protected $fillable = [
        'seguimiento_id',
        'instrumento',
        'respuesta',
    ];

    public function seguimiento()
    {
        return $this->belongsTo(Seguimiento::class);
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

