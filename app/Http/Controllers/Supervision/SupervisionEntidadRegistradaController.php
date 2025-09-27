<?php

namespace App\Http\Controllers\Supervision;

use App\Http\Controllers\Controller;
use App\Models\Supervision\SupervisionEntidadRegistrada;

class SupervisionEntidadRegistradaController extends Controller
{
    /**
     * Devuelve la ficha de supervisión (cabecera + secciones + items + files)
     */
    public function getEntidad(int $entidad)
    {
        $e = SupervisionEntidadRegistrada::with([
            'entidad',
            'categoria',
            'departamento',
            'provincia',
            'distrito',
            'secciones.items.files',
        ])->findOrFail($entidad);

        return response()->json([
            "id"           => $e->id,
            "entidad_id"   => $e->entidad_id,
            "entidad"      => $e->entidad,
            "categoria"    => $e->categoria,
            "departamento" => $e->departamento,
            "provincia"    => $e->provincia,
            "distrito"     => $e->distrito,
            "ubigeo"       => $e->ubigeo,
            "anio"         => $e->anio,
            "secciones"    => $e->secciones->map(function ($sec) {
                return [
                    "id"       => $sec->id,
                    "nombre"   => $sec->nombre,
                    "promedio" => $sec->promedio,
                    "items"    => $sec->items->map(function ($it) {
                        return [
                            "id"         => $it->id,
                            "nombre"     => $it->nombre,
                            "porcentaje" => $it->porcentaje,
                            "respuesta"  => $it->respuesta,
                            "observacion"=> $it->observacion,
                            "files"      => $it->files->map(function ($f) {
                                return [
                                    "id"          => $f->id,
                                    "name"        => $f->name,
                                    "descripcion" => $f->descripcion,
                                    "aprobado"    => $f->aprobado,
                                    "mime_type"   => $f->mime_type,
                                    "size"        => $f->size,
                                    "url"         => asset('storage/'.$f->path),
                                ];
                            }),
                        ];
                    }),
                ];
            }),
            "created_at"   => $e->created_at->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Historial por entidad (similar a Seguimiento)
     */
    public function historial(SupervisionEntidadRegistrada $entidad)
    {
        return SupervisionEntidadRegistrada::where('entidad_id', $entidad->entidad_id)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function (SupervisionEntidadRegistrada $e) {
                return [
                    "id"               => $e->id,
                    "anio"             => $e->anio,
                    "entidad"          => $e->entidad->nombre ?? null,
                    "fecha_registrada" => $e->created_at->format('Y-m-d'),
                ];
            });
    }
}
