<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seguimiento\RespuestaStore;
use App\Models\Seguimiento\Seguimiento;
use App\Models\Seguimiento\SeguimientoRespuesta;

class SeguimientoController extends Controller
{
    public function index()
    {
        return Seguimiento::with('entidad.distrito.provincia.departamento')
            ->when(request()->get("categoria"), function ($query, $categoria) {
                $query->where('categoria_id', $categoria);
            })
            ->get();
    }

    public function show(Seguimiento $seguimiento)
    {
        return $seguimiento::load([
            'entidad.distrito.provincia.departamento',
            'monitoreo_respuestas.files',
        ]);
    }

    public function store(RespuestaStore $request)
    {

        $er = Seguimiento::query()->create([
            'entidad_id' => $request->entidad_id,
            'anio' => $request->anio,
        ]);

        foreach ($request->respuestas as $respuestaData) {
            $respuesta = SeguimientoRespuesta::query()->create([
                'seguimiento_id' => $er->id,
                'instrumento' => $respuestaData['instrumento'],
                'respuesta'   => $respuestaData['respuesta'], // "si" o "no"
            ]);

            if (!empty($respuestaData['files'])) {
                foreach ($respuestaData['files'] as $uploadedFile) {
                    $file = $uploadedFile['file'];
                    $path = $file->store('seguimiento/respuestas');

                    $respuesta->files()->create([
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'disk' => 'local',
                        'size' => $file->getSize(),
                        'mime_type' => $file->getClientMimeType(),
                        'descripcion' => $uploadedFile['descripcion'] ?? null,
                        'aprobado' => ($uploadedFile['aprobado'] ?? 'no') === 'si' ? 'si' : 'no',
                    ]);
                }
            }
        }

        return response()->json(
            $er->load('entidad.distrito.provincia.departamento'),
            201
        );
    }
}
