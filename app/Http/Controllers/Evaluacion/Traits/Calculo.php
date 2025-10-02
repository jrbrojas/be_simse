<?php

namespace App\Http\Controllers\Evaluacion\Traits;

use App\Models\Monitoreo\EntidadRegistrada as MEntidadRegistrada;
use App\Models\Monitoreo\RespuestasPreguntas as MRespuestasPreguntas;
use App\Models\Seguimiento\EntidadRegistrada as SEntidadRegistrada;
use App\Models\Seguimiento\RespuestasPreguntas as SRespuestasPreguntas;
use App\Models\Supervision\SupervisionEntidadRegistrada;
use Closure;
use Illuminate\Database\Eloquent\Model;
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
                fn (MRespuestasPreguntas $r) => strtolower($r->respuesta) === 'si'
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
    ): float {
        if (!$supervision) {
            return 0;
        }

        return (float) $supervision->promedio_final;
    }

    /**
     * @return mixed[]
     */
protected function calculo(
    MEntidadRegistrada|Collection|null $monitoreo = null,
    SEntidadRegistrada|Collection|null $seguimiento = null,
    SupervisionEntidadRegistrada|Collection|null $supervision = null,
): array {
    // Obtener puntajes y saber si ese eje estuvo presente
    [$m, $hasM]  = $this->scoreFrom($monitoreo, fn($item) => $this->calculoMonitoreo($item));
    [$se, $hasSe] = $this->scoreFrom($seguimiento, fn($item) => $this->calculoSeguimiento($item));
    [$su, $hasSu] = $this->scoreFrom($supervision, fn($item) => $this->calculoSupervision($item));

    $presentes = ($hasM ? 1 : 0) + ($hasSe ? 1 : 0) + ($hasSu ? 1 : 0);
    // Evita división entre 0; si nada vino, considera 0 como total
    $total = $presentes > 0 ? ($m + $se + $su) / $presentes : 0.0;

    // Redondeo hacia abajo a 2 decimales (como hacías)
    $total = floor($total * 100) / 100;

    return [
        'monitoreo'  => $m,
        'seguimiento'=> $se,
        'supervision'=> $su,
        'evaluacion' => $total,
        'total'      => $total,
    ];
}

/**
 * Normaliza un valor que puede ser: Modelo | Collection | null
 * Devuelve [puntaje(float), presente(bool)]
 */
private function scoreFrom(Model|Collection|null $value, Closure $perItem): array
{
    // Si es null, no está presente
    if ($value === null) {
        return [0.0, false];
    }

    // Collection: promedia los puntajes de cada item
    if ($value instanceof Collection) {
        if ($value->isEmpty()) {
            return [0.0, false];
        }
        $sum = 0.0;
        $n   = 0;
        foreach ($value as $item) {
            // Asegura que el callback devuelva numérico
            $sum += (float) $perItem($item);
            $n++;
        }
        $avg = $n > 0 ? $sum / $n : 0.0;
        // Igual que tu lógica: floor a 2 decimales
        $avg = floor($avg * 100) / 100;
        return [$avg, true];
    }

    // Modelo individual
    $score = (float) $perItem($value);
    return [$score, true];
}}

