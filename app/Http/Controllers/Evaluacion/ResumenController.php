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

    public function getMonitoreo(?int $categoria, ?int $entidad_id): MEntidadRegistrada | null
    {

        if ($categoria) {
            return MEntidadRegistrada::query()
                ->with([
                    'entidad',
                    'distrito',
                    'provincia',
                    'departamento',
                    'categoria',
                    'respuestas.files'
                ])
                ->where('categoria_responsable_id', $categoria)
                ->orderBy('id', 'desc')
                ->first();
        }

        return MEntidadRegistrada::query()
            ->with(['respuestas.files',])
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getSeguimiento(?int $categoria, ?int $entidad_id): SEntidadRegistrada | null
    {
        if ($categoria) {
            return SEntidadRegistrada::query()
                ->with([
                    'entidad',
                    'distrito',
                    'provincia',
                    'departamento',
                    'respuestas.files',
                    'categoria',
                ])
                ->where('categoria_responsable_id', $categoria)
                ->orderBy('id', 'desc')
                ->first();
        }

        return SEntidadRegistrada::query()
            ->with(['respuestas.files',])
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * @todo falta terminar supervision
     */
    public function getSupervision(?int $categoria, ?int $entidad_id): ?SupervisionEntidadRegistrada
    {

        if($categoria){
            return SupervisionEntidadRegistrada::query()
                ->with([
                    'entidad',
                    'distrito',
                    'provincia',
                    'departamento',
                    'secciones',
                    'categoria',
                ])
                ->where('categoria_responsable_id', $categoria)
                ->orderBy('id', 'desc')
                ->first();
        }

        return SupervisionEntidadRegistrada::query()
            ->with('secciones')
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function resumen(int $entidad)
    {
        // Traemos la entidad registrada con todas sus relaciones
        $monitoreo = $this->getMonitoreo(null, $entidad);
        $seguimiento = $this->getSeguimiento(null, $entidad);
        $supervision = $this->getSupervision(null, $entidad);

        return response()->json([
            "respuestas" => compact(
                'monitoreo',
                'seguimiento',
                'supervision',
            ),
            "calculo" => $this->calculo($monitoreo, $seguimiento, $supervision),
        ]);
    }

    public function resumenCategoria(Request $request)
    {
        // Traemos la entidad registrada con todas sus relaciones filtrados por cateogria
        $monitoreo = $this->getMonitoreo($request->categoria, null);
        $seguimiento = $this->getSeguimiento($request->categoria, null);
        $supervision = $this->getSupervision($request->categoria, null);

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
