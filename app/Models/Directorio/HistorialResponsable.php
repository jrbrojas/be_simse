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

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function directorio()
    {
        return $this->belongsTo(Directorio::class);
    }
}
