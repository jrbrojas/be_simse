<?php

namespace App\Models\Directorio;

use App\Models\Depa;
use App\Models\Prov;
use App\Models\Ubigeo;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $table = 'responsables';
    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email',
        'telefono',
        'fecha_inicio',
        'fecha_fin',
        'fecha_registro',
        'id_entidad',
        'id_cargo',
        'id_categoria',
        'id_rol',
        'id_departamento',
        'id_provincia',
        'id_entidad',
        'ubigeo',
    ];

    public function distrito()
    {
        return $this->belongsTo(Ubigeo::class, "ubigeo", "ubigeo");
    }

    public function provincia()
    {
        return $this->belongsTo(Prov::class, "id_provincia", "idprov");
    }

    public function departamento()
    {
        return $this->belongsTo(Depa::class, "id_departamento", "iddpto");
    }
}
