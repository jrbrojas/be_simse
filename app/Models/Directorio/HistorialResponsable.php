<?php

namespace App\Models\Directorio;

use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;

class HistorialResponsable extends Model
{
    protected $fillable = [
        "responsable_id",
        "directorio_id",
        "fecha_inicio",
        "fecha_fin",
    ];

    public function directorio()
    {
        return $this->belongsTo(Directorio::class);
    }

    public function responsable()
    {
        return $this->belongsTo(Responsable::class);
    }

    public function entidad()
    {
        // a través del directorio, ya que HistorialResponsable → Directorio → Entidad
        return $this->hasOneThrough(
            Entidad::class,
            Directorio::class,
            'id',
            'id',
            'directorio_id',
            'entidad_id'
        );
    }
}
