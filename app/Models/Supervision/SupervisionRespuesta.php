<?php

namespace App\Models\Supervision;

use Illuminate\Database\Eloquent\Model;

class SupervisionRespuesta extends Model
{
    protected $fillable = [
        'supervision_id',
        'nombre',
        'promedio',
        'respuesta'
    ];

    public function entidad()
    {
        return $this->belongsTo(Supervision::class);
    }
}
