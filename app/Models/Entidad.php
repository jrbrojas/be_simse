<?php

namespace App\Models;

use App\Models\Directorio\CategoriaResponsable;
use App\Models\Directorio\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Entidad extends Model
{
    protected $table = 'entidades';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'departamento_id',
        'provincia_id',
        'distrito_id',
        'ubigueo',
        'nombre',
        'tipo',
        'fecha_registro',
        'ubigeo',
        'anio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_registro' => 'date',
        ];
    }

    public function responsables()
    {
        return $this->hasMany(Responsable::class, 'id_entidad');
    }

    /**
     * @return BelongsTo<Ubigeo>
     */
    public function distrito()
    {
        return $this->belongsTo(Ubigeo::class, 'distrito_id', 'id');
    }

    /**
     * @return HasOneThrough<Prov>
     */
    public function provincia()
    {
        return $this->belongsTo(Prov::class, 'provincia_id', 'id');
    }

    /**
     * @return BelongsTo<Depa>
     */
    public function departamento()
    {
        return $this->belongsTo(Depa::class, "departamento_id", "id");
    }

    /**
     * @return BelongsTo<CategoriaResponsable>
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaResponsable::class, 'categoria_id', 'id');
    }
}
