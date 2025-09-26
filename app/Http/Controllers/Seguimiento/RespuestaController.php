<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seguimiento\RespuestaStore;
use App\Models\Seguimiento\EntidadRegistrada;
use App\Models\Seguimiento\RespuestasPreguntas;

class RespuestaController extends Controller
{
    public function store(RespuestaStore $request)
    {

        $er = EntidadRegistrada::create([
            'entidad_id' => $request->entidad_id,
            'categoria_responsable_id' => $request->categoria_responsable_id,
            'ubigeo' => $request->ubigeo,
            'provincia_idprov' => $request->provincia_idprov,
            'departamento_iddpto' => $request->departamento_iddpto,
            'anio' => $request->anio,
        ]);

        foreach ($request->respuestas as $respuestaData) {
            $respuesta = RespuestasPreguntas::create([
                'seguimiento_entidad_registrada_id' => $er->id,
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
            $er->load('entidad', 'categoria'),
            201
        );
    }
}
