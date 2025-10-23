<?php

namespace App\Exports\Directorio;

use App\Models\Directorio\Responsable;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResponsablesDeEntidades implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * @param string[] $entidadesIds
     */
    public function __construct(
        protected array $entidadesIds,
    ) {
    }

    public function query()
    {
        return Responsable::query()
            ->select(
                'responsables.*',
                'entidades.nombre as entidad_nombre',
                'categorias_responsables.nombre as categoria',
                'roles_responsables.nombre as rol',
                'cargos_responsables.nombre as cargo',
            )
            ->whereIn('id_entidad', $this->entidadesIds)
            ->with([
                'distrito',
                'provincia',
                'departamento',
            ])
            ->leftJoin('entidades', 'responsables.id_entidad', '=', 'entidades.id')
            ->leftJoin('categorias_responsables', 'entidades.categoria_id', '=', 'categorias_responsables.id')
            ->leftJoin('roles_responsables', 'responsables.id_rol', '=', 'roles_responsables.id')
            ->leftJoin('cargos_responsables', 'responsables.id_cargo', '=', 'cargos_responsables.id')
            ->orderBy('entidades.nombre', 'ASC')
            ->orderBy('responsables.fecha_fin', 'DESC');
    }

    /**
     * @param Responsable $responsable
     */
    public function map($responsable): array
    {
        $fechaFin = Carbon::createFromDate($responsable->fecha_fin);
        // si fecha fin es antes de hoy, entonces es activo sin es inactivo
        $esActivo = $fechaFin ? $fechaFin->isFuture() : true;
        return [
            $responsable->entidad_nombre,
            $responsable->departamento->nombre,
            $responsable->provincia->nombre,
            $responsable->distrito->nombre,
            $responsable->distrito->ubigeo,
            $responsable->categoria,
            $responsable->nombre,
            $responsable->apellido,
            $responsable->dni,
            $responsable->telefono,
            $responsable->cargo,
            $responsable->rol,
            $responsable->email,
            Carbon::createFromDate($responsable->created_at)->format('Y-m-d'),
            $responsable->fecha_inicio,
            $responsable->fecha_fin,
            $esActivo ? 'Activo' : 'Inactivo',
        ];
    }


    public function headings(): array
    {
        return [
            'Departamento',
            'Provincia',
            'Distrito',
            'Ubigeo',
            'Entidad',
            'Categoria',
            'Nombre Responsable',
            'Apellido Responsable',
            'DNI',
            'Teléfono',
            'Cargo',
            'Rol',
            'Email',
            'Fecha Registro',
            'Fecha Inicio',
            'Fecha Fin',
            'Estado',
        ];
    }
}
