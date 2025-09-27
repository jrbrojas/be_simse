<?php

namespace App\Http\Controllers\Evaluacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Evaluacion\Traits\Calculo;
use App\Models\Monitoreo\EntidadRegistrada as MEntidadRegistrada;
use App\Models\Seguimiento\EntidadRegistrada as SEntidadRegistrada;
use App\Models\Supervision\SupervisionEntidadRegistrada;

class ResumenController extends Controller
{
    use Calculo;

    public function getMonitoreo(int $entidad_id): MEntidadRegistrada | null
    {
        return MEntidadRegistrada::query()
            ->with(['respuestas.files',])
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getSeguimiento(int $entidad_id): SEntidadRegistrada | null
    {
        return SEntidadRegistrada::query()
            ->with(['respuestas.files',])
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * @todo falta terminar supervision
     */
    public function getSupervision(int $entidad_id): ?SupervisionEntidadRegistrada
    {
        return SupervisionEntidadRegistrada::query()
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function resumen(int $entidad)
    {
        // Traemos la entidad registrada con todas sus relaciones
        $monitoreo = $this->getMonitoreo($entidad);
        $seguimiento = $this->getSeguimiento($entidad);
        $supervision = $this->getSupervision($entidad);

        return response()->json([
            "respuestas" => compact(
                'monitoreo',
                'seguimiento',
                'supervision',
            ),
            "calculo" => $this->calculo($monitoreo, $seguimiento, $supervision),
        ]);
    }
}
