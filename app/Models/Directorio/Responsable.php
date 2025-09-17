<?php

namespace App\Models\Directorio;

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
}
