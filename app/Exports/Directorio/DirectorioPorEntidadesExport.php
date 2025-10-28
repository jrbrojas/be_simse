<?php

namespace App\Exports\Directorio;

use App\Models\Directorio\HistorialResponsable;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DirectorioPorEntidadesExport implements FromQuery, WithHeadings, WithMapping
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
        return HistorialResponsable::query()
            ->select('historial_responsables.*')
            ->with([
                'responsable.cargo',
                'responsable.roles_responsable',
                'entidad.distrito.provincia.departamento',
                'entidad.categoria',
            ])
            ->leftJoin('directorios', 'directorios.id', '=', 'historial_responsables.directorio_id')
            ->leftJoin('entidades', 'directorios.entidad_id', '=', 'entidades.id')
            ->leftJoin('responsables', 'historial_responsables.responsable_id', '=', 'responsables.id')
            ->whereIn('entidad_id', $this->entidadesIds)
            ->orderBy('entidades.nombre', 'ASC')
            ->orderBy('responsables.id', 'DESC');
    }

    /**
     * @param HistorialResponsable $historialResponsable
     */
    public function map($historialResponsable): array
    {
        $fechaFin = Carbon::createFromDate($historialResponsable->responsable->fecha_fin);
        // si fecha fin es antes de hoy, entonces es activo sin es inactivo
        $esActivo = $fechaFin ? $fechaFin->isFuture() : true;
        return [
            $historialResponsable->entidad->nombre,
            $historialResponsable->entidad->distrito->provincia->departamento->nombre,
            $historialResponsable->entidad->distrito->provincia->nombre,
            $historialResponsable->entidad->distrito->nombre,
            $historialResponsable->entidad->distrito->codigo,
            $historialResponsable->entidad->categoria->nombre,
            $historialResponsable->responsable->nombre,
            $historialResponsable->responsable->apellido,
            $historialResponsable->responsable->dni,
            $historialResponsable->responsable->telefono,
            $historialResponsable->responsable->cargo->nombre,
            $historialResponsable->responsable->roles_responsable->nombre,
            $historialResponsable->responsable->email,
            Carbon::createFromDate($historialResponsable->created_at)->format('Y-m-d'),
            $historialResponsable->responsable->fecha_inicio,
            $historialResponsable->responsable->fecha_fin,
            $esActivo ? 'Activo' : 'Iresponsable->nactivo',
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
