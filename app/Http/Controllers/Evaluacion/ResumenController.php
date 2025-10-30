<?php

namespace App\Http\Controllers\Evaluacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Evaluacion\Traits\Calculo;
use App\Models\Monitoreo\Monitoreo;
use App\Models\Seguimiento\Seguimiento;
use App\Models\Supervision\Supervision;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResumenController extends Controller
{
    use Calculo;

    /**
     * @return Collection<int,Monitoreo>
     */
    public function getMonitoreo(?int $categoria = null, ?int $entidad_id = null): Collection
    {
        $ids = Monitoreo::query()
            ->when(request()->get("categoria"), function ($query, $categoria) {
                $query->whereRelation('entidad', 'categoria_id', $categoria);
            })
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('entidad_id')
            ->get()
            ->pluck('id');

        if ($ids->isEmpty()) {
            return collect([]);
        }

        return Monitoreo::with([
                'file',
                'entidad.categoria',
                'entidad.distrito.provincia.departamento',
                'monitoreo_respuestas'
            ])
            ->whereIn('id', $ids)
            ->when($entidad_id, function ($query, $entidad_id) {
                $query->where('entidad_id', $entidad_id);
            })
            ->get();
    }

    /**
     * @return Collection<int,Seguimiento>
     */
    public function getSeguimiento(?int $categoria = null, ?int $entidad_id = null): Collection
    {
        $ids = Seguimiento::query()
            ->when(request()->get("categoria"), function ($query, $categoria) {
                $query->whereRelation('entidad', 'categoria_id', $categoria);
            })
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('entidad_id')
            ->get()
            ->pluck('id');

        if ($ids->isEmpty()) {
            return collect([]);
        }

        return Seguimiento::with([
                'entidad.distrito.provincia.departamento',
                'entidad.categoria',
                'seguimiento_respuestas',
            ])
            ->whereIn('id', $ids)
            ->when($entidad_id, function ($query, $entidad_id) {
                $query->where('entidad_id', $entidad_id);
            })
            ->get();
    }

    /**
     * @return Collection<int,Supervision>
     */
    public function getSupervision(?int $categoria = null, ?int $entidad_id = null): Collection
    {
        $ids = Supervision::query()
            ->when(request()->get("categoria"), function ($query, $categoria) {
                $query->whereRelation('entidad', 'categoria_id', $categoria);
            })
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('entidad_id')
            ->get()
            ->pluck('id');

        if ($ids->isEmpty()) {
            return collect([]);
        }

        return Supervision::with([
                'entidad.distrito.provincia.departamento',
                'entidad.categoria',
                'supervision_respuestas',
            ])
            ->whereIn('id', $ids)
            ->when($entidad_id, function ($query, $entidad_id) {
                $query->where('entidad_id', $entidad_id);
            })
            ->get();
    }

    public function resumen(int $entidad): JsonResponse
    {
        // Traemos la entidad registrada con todas sus relaciones
        $monitoreo = $this->getMonitoreo(null, $entidad)->first();
        $seguimiento = $this->getSeguimiento(null, $entidad)->first();
        $supervision = $this->getSupervision(null, $entidad)->first();

        $monitoreo = $monitoreo ? $this->calculoMonitoreo($monitoreo) : 0;
        $seguimiento = $seguimiento ? $this->calculoSeguimiento($seguimiento) : 0;
        $supervision = $supervision ? $this->calculoSupervision($supervision) : 0;

        return response()->json(
            compact(
                'monitoreo',
                'seguimiento',
                'supervision',
            ),
        );
    }

    public function resumenCategoria(): JsonResponse
    {
        $categoria = request()->get('categoria', null);
        if ($categoria == null) {
            abort(400, 'Debe especificar la categoría');
        }
        // Traemos la entidad registrada con todas sus relaciones
        $monitoreo = $this->getMonitoreo($categoria);
        $seguimiento = $this->getSeguimiento($categoria);
        $supervision = $this->getSupervision($categoria);

        /** @var Collection<int,Monitoreo|Supervision|Seguimiento> $grouped */
        $grouped = collect(
            array_merge(
                $monitoreo->all(),
                $seguimiento->all(),
                $supervision->all(),
            )
        );

        $grouped = $grouped
            ->groupBy('entidad_id')
            ->map(function (Collection $item, $i) {
                /** @var Collection<int,Monitoreo|Supervision|Seguimiento> $item */
                $monitoreo = $item->where(fn($i) => $i instanceof Monitoreo)->first();
                $seguimiento = $item->where(fn($i) => $i instanceof Seguimiento)->first();
                $supervision = $item->where(fn($i) => $i instanceof Supervision)->first();

                $entidad = $item->first()->entidad;
                $entidad->respuestas = [
                    [
                        "nombre" => "Monitoreo",
                        "calculo" => $monitoreo ? $this->calculoMonitoreo($monitoreo) : 0,
                    ],
                    [
                        "nombre" => "Seguimiento",
                        "calculo" => $seguimiento ? $this->calculoSeguimiento($seguimiento) : 0,
                    ],
                    [
                        "nombre" => "Supervision",
                        "calculo" => $supervision ? $this->calculoSupervision($supervision) : 0,
                    ],
                ];
                return $entidad;
            });
        return response()->json($grouped->values());
    }
}
