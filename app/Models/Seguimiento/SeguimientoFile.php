<?php

namespace App\Models\Seguimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeguimientoFile extends Model
{
    protected $table = 'seguimiento_files';

    protected $fillable = [
        'name',
        'path',
        'disk',
        'size',
        'mime_type',
        'descripcion',
        'aprobado',
        'extra',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return route('anyfiles.show', ["type" => "seguimiento", "id" => $this->id]);
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
