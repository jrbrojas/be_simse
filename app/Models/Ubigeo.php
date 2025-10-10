<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $nombredpto
 * @property string $nombreprov
 * @property string $nombdist
 * @property string $ubigeo
 */
class Ubigeo extends Model
{
    protected $table = 'distritos';
    public $timestamps = false;
}
