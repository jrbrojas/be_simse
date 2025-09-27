<?php

namespace App\Http\Controllers\Supervision;

use App\Http\Controllers\Controller;
use App\Models\Supervision\SupervisionEntidadRegistrada;
use App\Models\Supervision\SupervisionSeccion;
use App\Models\Supervision\SupervisionItem;
use Illuminate\Http\Request;

class SupervisionController extends Controller
{
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
        $secciones = $request->input('secciones', []);

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
            
            $items = $secData['items'] ?? [];
            $sumaPorcentajes = 0;
            $cantidadItems   = 0;

            foreach ($items as $itemData) {
                $item = SupervisionItem::create([
                    'supervision_seccion_id' => $seccion->id,
                    'nombre'      => $itemData['nombre'] ?? 'Sin nombre',
                    'porcentaje'  => $itemData['porcentaje'] ?? 0,
                    //'respuesta'   => $itemData['respuesta'] ?? 'no',
                    //'observacion' => $itemData['observacion'] ?? null,
                ]);
        
                $sumaPorcentajes += (int) ($itemData['porcentaje'] ?? 0);
                $cantidadItems++;
        
                if (!empty($itemData['files'])) {
                    foreach ($itemData['files'] as $bundle) {
                        if (!isset($bundle['file'])) continue;
        
                        $uploaded = $bundle['file'];
                        $path     = $uploaded->store('supervision/files');
        
                        $item->files()->create([
                            'name'        => $uploaded->getClientOriginalName(),
                            'path'        => $path,
                            'disk'        => 'local',
                            'size'        => $uploaded->getSize(),
                            'mime_type'   => $uploaded->getClientMimeType(),
                            'descripcion' => $bundle['descripcion'] ?? null,
                            'aprobado'    => ($bundle['aprobado'] ?? 'no') === 'si' ? 'si' : 'no',
                        ]);
                    }
                }
            }

            // 3) Calcular promedio de la sección
            $promedioSeccion = 0;
            if ($cantidadItems > 0) {
                $promedioSeccion = round($sumaPorcentajes / $cantidadItems, 2);
                $seccion->update(['promedio' => $promedioSeccion]);
            }

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
        return SupervisionEntidadRegistrada::with('secciones.items.files')->findOrFail($id);
    }
}


