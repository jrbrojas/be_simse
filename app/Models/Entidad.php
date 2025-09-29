<?php

namespace App\Models;

use App\Models\Directorio\CategoriaResponsable;
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

    /**
     * @return BelongsTo<Ubigeo>
     */
    public function distrito()
    {
        return $this->belongsTo(Ubigeo::class, 'ubigeo', 'ubigeo');
    }

    /**
     * @return HasOneThrough<Prov>
     */
    public function provincia()
    {
        return $this->hasOneThrough(
            Prov::class,   // modelo final
            Ubigeo::class,    // modelo intermedio
            'ubigeo',           // FK en distritos que coincide con entidades.ubigeo
            'idprov',           // FK en provincias que coincide con distritos.idprov
            'ubigeo',           // clave local en entidades
            'idprov'            // clave local en distritos
        );
    }

    /**
     * @return BelongsTo<Depa>
     */
    public function departamento()
    {
        return $this->belongsTo(Depa::class, "departamento_id", "iddpto");
    }

    /**
     * @return BelongsTo<CategoriaResponsable>
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaResponsable::class, 'categoria_id', 'id');
    }
}
