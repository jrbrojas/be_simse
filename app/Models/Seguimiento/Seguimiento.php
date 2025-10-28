<?php

namespace App\Models\Seguimiento;

use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seguimiento extends Model
{
    // Campos permitidos para asignación masiva
    protected $fillable = [
        'entidad_id',
        'anio',
    ];

    /**
     * @return BelongsTo<Entidad>
     */
    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function seguimiento_respuestas()
    {
        return $this->hasMany(SeguimientoRespuesta::class);
    }
}
