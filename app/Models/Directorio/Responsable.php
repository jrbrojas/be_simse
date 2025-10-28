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
        // @todo no usar roles_responsables sino roles_responsable_id
        return $this->belongsTo(RolesResponsable::class, 'roles_responsables_id');
    }
}
