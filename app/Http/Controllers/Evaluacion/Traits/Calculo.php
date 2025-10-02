<?php

namespace App\Http\Controllers\Evaluacion\Traits;

use App\Models\Monitoreo\EntidadRegistrada as MEntidadRegistrada;
use App\Models\Monitoreo\RespuestasPreguntas as MRespuestasPreguntas;
use App\Models\Seguimiento\EntidadRegistrada as SEntidadRegistrada;
use App\Models\Seguimiento\RespuestasPreguntas as SRespuestasPreguntas;
use App\Models\Supervision\SupervisionEntidadRegistrada;
use Closure;
use Illuminate\Support\Collection;

trait Calculo
{
    protected function calculoMonitoreo(
        ?MEntidadRegistrada $monitoreo = null
    ): float {
        if (!$monitoreo) {
            return 0;
        }
        $total = $monitoreo->respuestas->count();
        $si = $monitoreo->respuestas
            ->filter(
                fn(MRespuestasPreguntas $r) => strtolower($r->respuesta) === 'si'
            )
            ->count();
        $division = ($si / $total) * 100;
        return floor($division * 100) / 100;
    }

    protected function calculoSeguimiento(
        ?SEntidadRegistrada $seguimiento = null
    ): float {
        if (!$seguimiento) {
            return 0;
        }
        $total = $seguimiento->respuestas->count();
        $si = $seguimiento->respuestas
            ->filter(
                fn(SRespuestasPreguntas $r) => strtolower($r->respuesta) === 'si'
            )
            ->count();
        $division = ($si / $total) * 100;
        return floor($division * 100) / 100;
    }

    /**
     * @todo falta terminar supervision
     */
    protected function calculoSupervision(
        ?SupervisionEntidadRegistrada $supervision = null
    ): float {
        if (!$supervision) {
            return 0;
        }

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
