<?php

namespace App\Models\Monitoreo;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RespuestasPreguntas extends Model
{
    protected $table = 'monitoreo_respuestas_de_preguntas';

    /**
     * @return MorphMany<File>
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
