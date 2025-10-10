<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prov extends Model
{
    protected $table = 'provincias';
    public $timestamps = false;

    protected $appends = ['idprov'];

    public function getIdprovAttribute(): string
    {
        return $this->ubigeo;
    }
}
