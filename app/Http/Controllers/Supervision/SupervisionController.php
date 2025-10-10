<?php

namespace App\Http\Controllers\Supervision;

use App\Http\Controllers\Controller;
use App\Models\Supervision\SupervisionEntidadRegistrada;
use App\Models\Supervision\SupervisionSeccion;
use App\Models\Supervision\SupervisionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupervisionController extends Controller
{
    public function index()
    {
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

    public function store(Request $request)
    {
        // 1) Cabecera
        $entidad = SupervisionEntidadRegistrada::create([
            'entidad_id'              => $request->input('entidad_id'),
            'categoria_responsable_id'=> $request->input('categoria_responsable_id'),
            'ubigeo'                  => $request->input('ubigeo'),
            'provincia_idprov'        => $request->input('provincia_idprov'),
            'departamento_iddpto'     => $request->input('departamento_iddpto'),
            'anio'                    => $request->input('anio'),
        ]);

        // Variables para calcular promedio final
        $sumaPromediosSecciones = 0;
        $cantidadSecciones      = 0;

        // 2) Secciones + items + archivos
        $all = $request->all();
        $secciones = $all['secciones'] ?? [];

        foreach ($secciones as $secData) {
            // Guardar la sección (promedio inicial = 0, se recalcula después)
            $seccion = SupervisionSeccion::create([
                'supervision_entidad_registrada_id' => $entidad->id,
                'nombre'   => $secData['nombre']   ?? 'Sin nombre',
                'respuesta' => $secData['respuesta'] ?? 'no',
                'promedio' => 0,
            ]);

             // Si la sección está marcada como "no", salta ítems y promedio queda en 0
            if ($seccion->respuesta === 'no') {
                continue;
            }

            $items = $secData['item'] ?? [];
            $sumaPorcentajes = 0;
            $cantidadItems   = 0;

            foreach ($items as $itemData) {
                $item = SupervisionItem::create([
                    'supervision_seccion_id' => $seccion->id,
                    'nombre'      => $itemData['nombre'] ?? 'Sin nombre',
                    'porcentaje'  => $itemData['porcentaje'] ?? 0,
                ]);

                $sumaPorcentajes += (int) ($itemData['porcentaje'] ?? 0);
                $cantidadItems++;

                if (!empty($itemData['file'])) {
                    $files = [$itemData['file']];
                    foreach ($files as $uploaded) {
                        $path     = $uploaded->store('supervision/files');

                        $item->files()->create([
                            'name'        => $uploaded->getClientOriginalName(),
                            'path'        => $path,
                            'disk'        => 'local',
                            'size'        => $uploaded->getSize(),
                            'mime_type'   => $uploaded->getClientMimeType(),
                            'descripcion' => $itemData['descripcion'] ?? null,
                            'porcentaje'    => ($itemData['porcentaje'] ?? 'no') === 'si' ? 'si' : 'no',
                            'promedio' => $itemData['promedio'] ?? 0,
                        ]);
                    }
                }
            }

            // 3) Calcular promedio de la sección
            $promedioSeccion = 0;
            $promedioSeccion = round($sumaPorcentajes / 4, 2);
            $seccion->update(['promedio' => $promedioSeccion]);

            // acumular para promedio final
            $sumaPromediosSecciones += $promedioSeccion;
            $cantidadSecciones++;
        }

        // 4) Calcular Promedio Final de la entidad
        $promedioFinal = 0;
        if ($cantidadSecciones > 0) {
            $promedioFinal = round($sumaPromediosSecciones / $cantidadSecciones, 2);
        }
        $entidad->update(['promedio_final' => $promedioFinal]);

        return response()->json(
            $entidad->load('secciones.items.files'),
            201
        );
    }

    public function show(int $id)
    {
        return SupervisionEntidadRegistrada::with(['secciones', 'items', 'files'])->findOrFail($id);
    }
}


