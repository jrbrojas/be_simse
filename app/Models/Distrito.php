<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $nombredpto
 * @property string $nombreprov
 * @property string $nombdist
 * @property string $ubigeo
 */
class Distrito extends Model
{
    public $timestamps = false;

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
}
