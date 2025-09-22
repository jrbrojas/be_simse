<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'path',
        'disk',
        'size',
        'description',
        'mime_type',
        'extra',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return route('files.show', $this->id);
    }
}
