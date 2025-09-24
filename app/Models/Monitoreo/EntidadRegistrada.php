<?php

namespace App\Models\Monitoreo;

use App\Models\Depa;
use App\Models\Directorio\CategoriaResponsable;
use App\Models\Entidad;
use App\Models\Prov;
use App\Models\Ubigeo;
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

    public function categoria()
    {
        return $this->belongsTo(CategoriaResponsable::class, "categoria_responsable_id", "id");
    }

    public function distrito()
    {
        return $this->belongsTo(Ubigeo::class, "ubigeo", "ubigeo");
    }

    public function provincia()
    {
        return $this->belongsTo(Prov::class, "provincia_idprov", "idprov");
    }

    public function departamento()
    {
        return $this->belongsTo(Depa::class, "departamento_iddpto", "iddpto");
    }
}
