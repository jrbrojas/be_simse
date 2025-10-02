<?php

namespace App\Http\Controllers\Evaluacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Evaluacion\Traits\Calculo;
use App\Models\Monitoreo\EntidadRegistrada as MEntidadRegistrada;
use App\Models\Seguimiento\EntidadRegistrada as SEntidadRegistrada;
use App\Models\Supervision\SupervisionEntidadRegistrada;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResumenController extends Controller
{
    use Calculo;

    public function getMonitoreo(?int $categoria, ?int $entidad_id): MEntidadRegistrada | null | Collection
    {

        if ($categoria) {

            $ids = MEntidadRegistrada::query()
                ->select(DB::raw('MAX(id) as max_id'))
                ->groupBy('entidad_id')
                ->get();

            $ids = $ids->pluck('max_id')->toArray();

            return MEntidadRegistrada::with([
                'entidad',
                'respuestas',
                'departamento',
                'provincia',
                'distrito'
            ])
                ->when(request()->get("categoria"), function ($query, $categoria) {
                    $query->where('categoria_responsable_id', $categoria);
                })
                ->whereIn('id', $ids)->get();
        }

        return MEntidadRegistrada::query()
            ->with(['respuestas.files',])
            ->where('entidad_id', $entidad_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getSeguimiento(?int $categoria, ?int $entidad_id): SEntidadRegistrada | null | Collection
    {
        if ($categoria) {
            // Obtenemos el último registro por entidad_id
            $ids = SEntidadRegistrada::query()
                ->select(DB::raw('MAX(id) as max_id'))
                ->groupBy('entidad_id')
                ->pluck('max_id')
                ->toArray();

            // Devolvemos las entidades con sus relaciones
            return SEntidadRegistrada::with([
                'entidad',
                'categoria',
                'departamento',
                'respuestas',
                'provincia',
                'distrito',
                'file'
            ])
                ->when(request()->get('categoria'), function ($query, $categoria) {
                    $query->where('categoria_responsable_id', $categoria);
                })
                ->whereIn('id', $ids)
                ->get();
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
    public function getSupervision(?int $categoria, ?int $entidad_id): SupervisionEntidadRegistrada | null | Collection
    {

        if ($categoria) {
            // Obtenemos el último registro por entidad_id
            $ids = SupervisionEntidadRegistrada::query()
                ->select(DB::raw('MAX(id) as max_id'))
                ->groupBy('entidad_id')
                ->pluck('max_id')
                ->toArray();

            // Devolvemos las entidades con sus relaciones
            return SupervisionEntidadRegistrada::with([
                'entidad',
                'categoria',
                'departamento',
                'secciones',
                'provincia',
                'distrito',
            ])
                ->when(request()->get('categoria'), function ($query, $categoria) {
                    $query->where('categoria_responsable_id', $categoria);
                })
                ->whereIn('id', $ids)
                ->get();
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

    public function resumenCategoria()
    {
        // Traemos la entidad registrada con todas sus relaciones filtrados por cateogria
        $monitoreo = $this->getMonitoreo(request()->get("categoria"), null);
        $seguimiento = $this->getSeguimiento(request()->get("categoria"), null);
        $supervision = $this->getSupervision(request()->get("categoria"), null);

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
