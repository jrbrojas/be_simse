<?php

namespace App\Models\Monitoreo;

use App\Models\Entidad;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Monitoreo extends Model
{
    /**
     * @return MorphOne<File>
     */
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function monitoreo_respuestas()
    {
        return $this->hasMany(MonitoreoRespuesta::class);
    }
}
