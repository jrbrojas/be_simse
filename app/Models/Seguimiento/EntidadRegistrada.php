<?php

namespace App\Models\Seguimiento;

use App\Models\Depa;
use App\Models\Directorio\CategoriaResponsable;
use App\Models\Entidad;
use App\Models\File;
use App\Models\Prov;
use App\Models\Ubigeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class EntidadRegistrada extends Model
{
    protected $table = 'seguimiento_entidad_registrada';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'entidad_id',
        'categoria_responsable_id',
        'ubigeo',
        'provincia_idprov',
        'departamento_iddpto',
        'anio',
        'aprobado',
        'instrumento',
    ];

    /**
     * @return MorphOne<File>
     */
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    /**
     * @return BelongsTo<Entidad>
     */
    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestasPreguntas::class, 'seguimiento_entidad_registrada_id');
    }

    /**
     * @return BelongsTo<CategoriaResponsable>
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaResponsable::class, "categoria_responsable_id", "id");
    }

    /**
     * @return BelongsTo<Ubigeo>
     */
    public function distrito()
    {
        return $this->belongsTo(Ubigeo::class, "ubigeo", "ubigeo");
    }

    /**
     * @return BelongsTo<Prov>
     */
    public function provincia()
    {
        return $this->belongsTo(Prov::class, "provincia_idprov", "idprov");
    }

    /**
     * @return BelongsTo<Depa>
     */
    public function departamento()
    {
        return $this->belongsTo(Depa::class, "departamento_iddpto", "iddpto");
    }
}
