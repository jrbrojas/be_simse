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

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return route('anyfiles.show', ["type" => "supervision", "id" => $this->id]);
    }

    public function fileable()
    {
        return $this->morphTo();
    }
}
