<?php

namespace App\Models\Supervision;

use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supervision extends Model
{
    protected $fillable = [
        'entidad_id',
        'anio',
        'promedio_final',
    ];

    /**
     * Relaciones básicas
     */
    public function entidad(): BelongsTo
    {
        return $this->belongsTo(Entidad::class);
    }

    /**
     * Relaciones con Supervisión
     */
    public function supervision_respuesta()
    {
        return $this->hasMany(SupervisionRespuesta::class);
    }
}
