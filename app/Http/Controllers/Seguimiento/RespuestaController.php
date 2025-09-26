<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seguimiento\RespuestaStore;
//use App\Models\Seguimiento\RespuestasPreguntas;
use App\Models\Seguimiento\EntidadRegistrada;

class RespuestaController extends Controller
{
    /*
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
        $url = "seguimiento/respuestas/{$unixtime}-{$name}";
        Storage::disk('local')->put($url, file_get_contents($file));
        return $url;
    }
    */

    public function store(RespuestaStore $request)
    {
        $er = new EntidadRegistrada();
        $er->entidad_id = $request->entidad_id;
        $er->categoria_responsable_id = $request->categoria_responsable_id;
        $er->ubigeo = $request->ubigeo;
        $er->provincia_idprov = $request->provincia_idprov;
        $er->departamento_iddpto = $request->departamento_iddpto;
        $er->anio = $request->anio;
        $er->save();
        return $er;
    }
}
