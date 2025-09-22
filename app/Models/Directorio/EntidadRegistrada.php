<?php

namespace App\Models\Directorio;

use Illuminate\Database\Eloquent\Model;

class EntidadRegistrada extends Model
{
    protected $table = 'directorio_entidad';
    protected $fillable = [
        "entidad_id",
        "categoria_id",
        "fecha_registro",
    ];
}
