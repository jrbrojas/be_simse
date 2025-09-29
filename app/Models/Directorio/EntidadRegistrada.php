<?php

namespace App\Models\Directorio;

use App\Models\Depa;
use App\Models\Entidad;
use App\Models\Prov;
use App\Models\Ubigeo;
use Illuminate\Database\Eloquent\Model;

class EntidadRegistrada extends Model
{
    protected $table = 'directorio_entidad';
    protected $fillable = [
        "entidad_id",
        "categoria_id",
        "fecha_registro",
    ];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaResponsable::class, "categoria_id", "id");
    }
}
