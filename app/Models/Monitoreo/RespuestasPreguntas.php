<?php

namespace App\Models\Monitoreo;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;

class RespuestasPreguntas extends Model
{
    protected $table = 'monitoreo_respuestas_de_preguntas';

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
