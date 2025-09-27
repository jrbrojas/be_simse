<?php

namespace App\Models\Supervision;

use App\Models\Depa;
use App\Models\Directorio\CategoriaResponsable;
use App\Models\Entidad;
use App\Models\Prov;
use App\Models\Ubigeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupervisionEntidadRegistrada extends Model
{
    protected $table = 'supervision_entidad_registrada';

    protected $fillable = [
        'entidad_id',
        'categoria_responsable_id',
        'ubigeo',
        'provincia_idprov',
        'departamento_iddpto',
        'anio',
        'promedio_final',
    ];

    /**
     * Relaciones básicas
     */
    public function entidad(): BelongsTo
    {
        return $this->belongsTo(Entidad::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaResponsable::class, "categoria_responsable_id", "id");
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Ubigeo::class, "ubigeo", "ubigeo");
    }

    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Prov::class, "provincia_idprov", "idprov");
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Depa::class, "departamento_iddpto", "iddpto");
    }

    /**
     * Relaciones con Supervisión
     */
    public function secciones()
    {
        return $this->hasMany(SupervisionSeccion::class);
    }
}
