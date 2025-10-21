<?php

namespace App\Models\Directorio;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $fillable = [
        'cargo_id',
        'roles_responsables_id',
        'nombre',
        'apellido',
        'dni',
        'email',
        'telefono',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function roles_responsable()
    {
        return $this->belongsTo(RolesResponsable::class);
    }
}
