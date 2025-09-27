<?php

namespace App\Http\Controllers\Evaluacion\Traits;

use App\Models\Monitoreo\EntidadRegistrada as MEntidadRegistrada;
use App\Models\Monitoreo\RespuestasPreguntas as MRespuestasPreguntas;
use App\Models\Seguimiento\EntidadRegistrada as SEntidadRegistrada;
use App\Models\Seguimiento\RespuestasPreguntas as SRespuestasPreguntas;
use App\Models\Supervision\SupervisionEntidadRegistrada;

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
                fn (MRespuestasPreguntas $r) => strtolower($r->respuesta) === 'si'
            )
            ->count();
        $division = ($si / $total) * 100;
        return floor($division * 100) / 100;
    }

    protected function calculoSeguimiento(
        ?SEntidadRegistrada $seguimiento = null
    ): int {
        if (!$seguimiento) {
            return 0;
        }
        $total = $seguimiento->respuestas->count();
        $si = $seguimiento->respuestas
            ->filter(
                fn (SRespuestasPreguntas $r) => strtolower($r->respuesta) === 'si'
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
    ): int {
        if (!$supervision) {
            return 0;
        }

        return (float) $supervision->promedio_final;
    }

    /**
     * @return mixed[]
     */
    protected function calculo(
        ?MEntidadRegistrada $monitoreo = null,
        ?SEntidadRegistrada $seguimiento = null,
        ?SupervisionEntidadRegistrada $supervision = null,
    ): array {
        $m = $this->calculoMonitoreo($monitoreo);
        $se = $this->calculoSeguimiento($seguimiento);
        $su = $this->calculoSupervision($supervision);

        $total = ($m + $se + $su) / 3;
        $total = floor($total * 100) / 100;

        return [
            "monitoreo" => $m,
            "seguimiento" => $se,
            "supervision" => $su,
            "evaluacion" => $total,
            "total" => $total,
        ];
    }
}

