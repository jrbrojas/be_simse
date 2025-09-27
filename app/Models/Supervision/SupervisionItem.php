<?php

namespace App\Models\Supervision;

use Illuminate\Database\Eloquent\Model;

class SupervisionItem extends Model
{
    protected $table = 'supervision_items';

    protected $fillable = [
        'supervision_seccion_id',
        'nombre',
        'porcentaje',
        //'respuesta',
        //'observacion',
    ];

    public function seccion()
    {
        return $this->belongsTo(SupervisionSeccion::class, 'supervision_seccion_id');
    }

    public function files()
    {
        return $this->morphMany(SupervisionFile::class, 'fileable');
    }
}

