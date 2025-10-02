<?php

namespace App\Models\Supervision;

use Illuminate\Database\Eloquent\Model;

class SupervisionSeccion extends Model
{
    protected $table = 'supervision_secciones';

    protected $fillable = [
        'supervision_entidad_registrada_id',
        'nombre',
        'promedio',
        'respuesta'
    ];

    public function entidad()
    {
        return $this->belongsTo(SupervisionEntidadRegistrada::class, 'supervision_entidad_registrada_id');
    }

    public function items()
    {
        return $this->hasMany(SupervisionItem::class);
    }
}
