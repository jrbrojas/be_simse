<?php

namespace App\Models\Monitoreo;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MonitoreoRespuesta extends Model
{
    /**
     * @return MorphMany<File>
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
