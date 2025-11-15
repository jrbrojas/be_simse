<?php

namespace App\Exports\Monitoreo;

use App\Models\Monitoreo\Monitoreo;
use App\Models\Monitoreo\MonitoreoRespuesta;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * @implements WithMapping<Monitoreo>
 */
class MonitoreoPorEntidadesExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting
{
    use Exportable;

    protected const CANTIDAD_PREGUNTAS = 30;

    /**
     * @param string[] $monitoreosIds
     */
    public function __construct(
        protected array $monitoreosIds,
    ) {
    }

    public function query()
    {
        return Monitoreo::query()
            ->select('monitoreos.*')
            ->with([
                'entidad.categoria',
                'entidad.distrito.provincia.departamento',
                'monitoreo_respuestas'
            ])
            ->leftJoin('entidades', 'monitoreos.entidad_id', '=', 'entidades.id')
            ->whereIn('monitoreos.id', $this->monitoreosIds)
            ->orderBy('entidades.nombre', 'ASC')
        ;
    }

    /**
     * @param Monitoreo $monitoreo
     */
    public function map($monitoreo): array
    {
        $basic = [
            $monitoreo->entidad->nombre,
            $monitoreo->entidad->distrito->provincia->departamento->nombre,
            $monitoreo->entidad->distrito->provincia->nombre,
            $monitoreo->entidad->distrito->nombre,
            (string) $monitoreo->entidad->distrito->codigo,
        ];
        $respuestas = [];
        for ($i = 1; $i <= self::CANTIDAD_PREGUNTAS; $i++) {
            /** @var ?MonitoreoRespuesta $monitoreoRespuesta */
            $monitoreoRespuesta = $monitoreo
                ->monitoreo_respuestas
                ->where('codigo', "P{$i}")
                ->first();

            $respuestas[] = strtoupper($monitoreoRespuesta?->respuesta ?? 'NO');
        }
        $cantidadSI = count(array_filter($respuestas, fn ($respuesta) => $respuesta === 'SI'));
        $porcentajeSI = ($cantidadSI / self::CANTIDAD_PREGUNTAS) * 100;

        return array_merge(
            $basic,
            $respuestas,
            [number_format($porcentajeSI, 2) . " %"],
        );
    }


    /**
     * Array de cabeceras, empieza con Entidad, Departamento, Provincia,
     * Distrito, Ubigeo, luego sigue del P1 al P30 y el total
     *
     * @return string[]
     */
    public function headings(): array
    {
        $basic = [
            'Entidad',
            'Departamento',
            'Provincia',
            'Distrito',
            'Ubigeo',
        ];
        $respuestas = [];
        for ($i = 1; $i <= self::CANTIDAD_PREGUNTAS; $i++) {
            $respuestas[] = "P{$i}";
        }
        return array_merge(
            $basic,
            $respuestas,
            ['Total'],
        );
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
