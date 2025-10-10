<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depa extends Model
{
    protected $table = 'departamentos';
    public $timestamps = false;

    protected $appends = ['iddpto'];

    public function getIddptoAttribute(): string
    {
        return $this->codigo;
    }
}
