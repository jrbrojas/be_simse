<?php

namespace App\Models\Supervision;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    /**
     * Relación con archivos adjuntos
     * @return MorphMany<File>
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
