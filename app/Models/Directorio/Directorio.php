<?php

namespace App\Models\Directorio;

use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;

class Directorio extends Model
{
    protected $fillable = [
        "entidad_id",
        "responsable_id",
        "fecha_registro",
    ];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function responsable()
    {
        return $this->belongsTo(Responsable::class);
    }

    public function historial_responsables()
    {
        return $this->hasMany(HistorialResponsable::class);
    }
}
