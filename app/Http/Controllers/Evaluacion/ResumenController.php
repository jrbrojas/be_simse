<?php

namespace App\Http\Controllers\Evaluacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Evaluacion\Traits\Calculo;
use App\Models\Monitoreo\EntidadRegistrada as MEntidadRegistrada;
use App\Models\Seguimiento\EntidadRegistrada as SEntidadRegistrada;
use App\Models\Supervision\SupervisionEntidadRegistrada;
use Illuminate\Http\Request;

class ResumenController extends Controller
{
    use Calculo;

    public function getMonitoreo(?int $categoria, int $entidad_id): MEntidadRegistrada | null
    {
        return MEntidadRegistrada::query()
            ->with(['respuestas.files',])
            ->when($categoria, function ($query) use ($categoria) {
                $query->where('categoria_responsable_id', $categoria);
            })
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getSeguimiento(?int $categoria, int $entidad_id): SEntidadRegistrada | null
    {
        return SEntidadRegistrada::query()
            ->with(['respuestas.files',])
            ->when($categoria, function ($query) use ($categoria) {
                $query->where('categoria_responsable_id', $categoria);
            })
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * @todo falta terminar supervision
     */
    public function getSupervision(?int $categoria, int $entidad_id): ?SupervisionEntidadRegistrada
    {
        return SupervisionEntidadRegistrada::query()
            ->with('secciones')
            ->when($categoria, function ($query) use ($categoria) {
                $query->where('categoria_responsable_id', $categoria);
            })
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function resumen(Request $request, int $entidad)
    {
        // Traemos la entidad registrada con todas sus relaciones
        $monitoreo = $this->getMonitoreo($request->categoria, $entidad);
        $seguimiento = $this->getSeguimiento($request->categoria, $entidad);
        $supervision = $this->getSupervision($request->categoria, $entidad);

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
