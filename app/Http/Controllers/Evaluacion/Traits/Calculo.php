<?php

namespace App\Http\Controllers\Evaluacion\Traits;

use App\Models\Monitoreo\EntidadRegistrada as MEntidadRegistrada;
use App\Models\Monitoreo\Monitoreo;
use App\Models\Monitoreo\MonitoreoRespuesta;
use App\Models\Monitoreo\RespuestasPreguntas as MRespuestasPreguntas;
use App\Models\Seguimiento\EntidadRegistrada as SEntidadRegistrada;
use App\Models\Seguimiento\RespuestasPreguntas as SRespuestasPreguntas;
use App\Models\Seguimiento\Seguimiento;
use App\Models\Seguimiento\SeguimientoRespuesta;
use App\Models\Supervision\Supervision;
use App\Models\Supervision\SupervisionEntidadRegistrada;
use Closure;
use Illuminate\Support\Collection;

trait Calculo
{
    protected function calculoMonitoreo(
        Monitoreo $monitoreo
    ): float {
        $total = $monitoreo->monitoreo_respuestas->count();
        $si = $monitoreo->monitoreo_respuestas
            ->filter(
                fn(MonitoreoRespuesta $r) => strtolower($r->respuesta) === 'si'
            )
            ->count();
        $division = ($si / $total) * 100;
        return floor($division * 100) / 100;
    }

    protected function calculoSeguimiento(
        Seguimiento $seguimiento,
    ): float {
        $total = $seguimiento->seguimiento_respuestas->count();
        $si = $seguimiento->seguimiento_respuestas
            ->filter(
                fn(SeguimientoRespuesta $r) => strtolower($r->respuesta) === 'si'
            )
            ->count();
        $division = ($si / $total) * 100;
        return floor($division * 100) / 100;
    }

    protected function calculoSupervision(
        Supervision $supervision
    ): float {
        return (float) $supervision->promedio_final;
    }

    /**
     * @return mixed[]
     */
    // protected function calculo(
    //     ?MEntidadRegistrada $monitoreo = null,
    //     ?SEntidadRegistrada $seguimiento = null,
    //     ?SupervisionEntidadRegistrada $supervision = null,
    // ): array {
    //     $m = $this->calculoMonitoreo($monitoreo);
    //     $se = $this->calculoSeguimiento($seguimiento);
    //     $su = $this->calculoSupervision($supervision);

    //     $total = ($m + $se + $su) / 3;
    //     $total = floor($total * 100) / 100;

    //     return [
    //         "monitoreo" => $m,
    //         "seguimiento" => $se,
    //         "supervision" => $su,
    //         "evaluacion" => $total,
    //         "total" => $total,
    //     ];
    // }

    protected function calculo(
        MEntidadRegistrada|Collection|null $monitoreo = null,
        SEntidadRegistrada|Collection|null $seguimiento = null,
        SupervisionEntidadRegistrada|Collection|null $supervision = null,
    ): array {
        return [
            'monitoreo'   => $this->procesarColeccion($monitoreo, fn($item) => $this->calculoMonitoreo($item)),
            'seguimiento' => $this->procesarColeccion($seguimiento, fn($item) => $this->calculoSeguimiento($item)),
            'supervision' => $this->procesarColeccion($supervision, fn($item) => $this->calculoSupervision($item)),
        ];
    }

    /**
     * Procesa un valor que puede ser: Modelo | Collection | null
     * Devuelve un array de resultados [{id, total}, ...]
     */
    private function procesarColeccion($value, Closure $perItem): array
    {
        if ($value === null) {
            return [];
        }

        if ($value instanceof Collection) {
            return $value->map(function ($item) use ($perItem) {
                return [
                    'id'    => $item->id,
                    'total' => (float) $perItem($item),
                ];
            })->all();
        }

        // Caso modelo único
        return [[
            'id'    => $value->id,
            'total' => (float) $perItem($value),
        ]];
    }
}
