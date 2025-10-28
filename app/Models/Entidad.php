<?php

namespace App\Models;

use App\Models\Directorio\Categoria;
use App\Models\Monitoreo\Monitoreo;
use App\Models\Seguimiento\Seguimiento;
use App\Models\Supervision\Supervision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'categoria_id',
        'distrito_id',
        'nombre',
        'tipo',
        'fecha_registro',
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
     * @return BelongsTo<Distrito>
     */
    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }

    /**
     * @return BelongsTo<Categoria>
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function monitoreos()
    {
        return $this->hasMany(Monitoreo::class);
    }

    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class);
    }

    public function supervisions()
    {
        return $this->hasMany(Supervision::class);
    }
}
