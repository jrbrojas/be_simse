<?php

namespace App\Http\Controllers\Monitoreo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Monitoreo\RespuestaStore;
use App\Models\Monitoreo\EntidadRegistrada;
use App\Models\Monitoreo\RespuestasPreguntas;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RespuestaController extends Controller
{
    public function index()
    {
        return RespuestasPreguntas::with('files')->get();
    }

    public function guardarArchivo(?UploadedFile $file): string
    {
        if (null === $file) {
            return "";
        }
        $name = $file->getClientOriginalName();
        $unixtime = time();
        $url = "monitoreo/respuestas/{$unixtime}-{$name}";
        Storage::disk('local')->put($url, file_get_contents($file));
        return $url;
    }

    public function guardarArchivoER(EntidadRegistrada $er, ?UploadedFile $file): string
    {
        if (null === $file) {
            return "";
        }
        $name = $file->getClientOriginalName();
        $unixtime = time();
        $url = "monitoreo/{$er->id}/{$unixtime}-{$name}";
        Storage::disk('local')->put($url, file_get_contents($file));
        return $url;
    }

    public function store(RespuestaStore $request)
    {
        $er = new EntidadRegistrada();
        $er->entidad_id = $request->entidad_id;
        $er->categoria_responsable_id = $request->categoria_responsable_id;
        $er->ubigeo = $request->ubigeo;
        $er->provincia_idprov = $request->provincia_idprov;
        $er->departamento_iddpto = $request->departamento_iddpto;
        $er->anio = $request->anio;
        $er->que_implementa = $request->que_implementa;
        $er->sustento = $request->sustento;
        $er->n_personas_en_la_instancia = $request->n_personas_en_la_instancia;
        $er->n_personas_grd = $request->n_personas_grd;
        $er->save();

        if ($request->archivo) {
            $file = $request->archivo;
            $archivo = [
                'name' => $file->getClientOriginalName(),
                'path' => $this->guardarArchivoER($er, $file),
                'disk' => 'local',
                'size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'description' => "",
                'extra' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $er->file()->create($archivo);
        }

        foreach ($request->respuestas as $respuesta) {
            $r = new RespuestasPreguntas();
            $r->codigo = $respuesta['codigo'];
            $r->op = $respuesta['op'];
            $r->titulo = $respuesta['titulo'];
            $r->pregunta = $respuesta['pregunta'];
            $r->type = $respuesta['type'];
            $r->respuesta = strtolower($respuesta['respuesta']);
            $r->cantidad_evidencias = "0";
            $r->porcentaje = "0";
            if ($r->respuesta == 'si') {
                $r->cantidad_evidencias = $respuesta['cantidad_evidencias'];
                $r->porcentaje = $respuesta['porcentaje'];
            }
            $r->monitoreo_entidad_registrada_id = $er->id;
            $r->save();

            if (array_key_exists('files', $respuesta)) {
                $data = [];
                foreach ($respuesta["files"] as $item) {
                    $file = $item["file"];
                    $descripcion = $item["descripcion"];

                    $data[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $this->guardarArchivo($file),
                        'disk' => 'local',
                        'size' => $file->getSize(),
                        'mime_type' => $file->getClientMimeType(),
                        'description' => $descripcion,
                        'extra' => json_encode(compact('descripcion')),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                $r->files()->createMany($data);
            }
        }

        return $er;
    }
}
