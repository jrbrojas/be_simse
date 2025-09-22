<?php

namespace App\Models\Monitoreo;

use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;

class EntidadRegistrada extends Model
{
    protected $table = 'monitoreo_entidad_registrada';

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestasPreguntas::class, 'monitoreo_entidad_registrada_id');
    }
}
