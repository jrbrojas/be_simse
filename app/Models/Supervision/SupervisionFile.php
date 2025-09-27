<?php

namespace App\Models\Supervision;

use Illuminate\Database\Eloquent\Model;

class SupervisionFile extends Model
{
    protected $table = 'supervision_files';

    protected $fillable = [
        'name',
        'path',
        'disk',
        'size',
        'mime_type',
        'descripcion',
        'porcentaje',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
