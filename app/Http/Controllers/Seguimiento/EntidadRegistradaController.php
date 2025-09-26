<?php

namespace App\Http\Controllers\Seguimiento;

//use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Seguimiento\EntidadRegistrada;

class EntidadRegistradaController extends Controller
{
    public function getEntidad(int $entidad)
    {
        // Traemos la entidad registrada con todas sus relaciones
        $e = EntidadRegistrada::query()
            ->with([
                'entidad',
                'categoria',
                'departamento',
                'provincia',
                'distrito',
                'file',
                'respuestas.files',
            ])
            ->where('id', $entidad)
            ->firstOrFail();

        return response()->json([
            "id" => $e->id,
            "entidad" => $e->entidad->nombre ?? null,
            "categoria" => $e->categoria->nombre ?? null,
            "departamento" => $e->departamento->nombre ?? null,
            "provincia" => $e->provincia->nombre ?? null,
            "distrito" => $e->distrito->distrito ?? null,
            "ubigeo" => $e->ubigeo,
            "anio" => $e->anio,
            "respuestas" => $e->respuestas,
            /*
            "instrumento" => $e->instrumento,
            "aprobado" => $e->aprobado,
            "file" => $e->file ? [
                "path" => $e->file->path,
                "url" => asset("storage/" . $e->file->path),
            ] : null,
            */
            "created_at" => $e->created_at->format('Y-m-d H:i:s'),
        ]);
    }

    public function historial(EntidadRegistrada $entidad)
    {
        return EntidadRegistrada::query()
            ->where('entidad_id', $entidad->entidad_id)
            ->get()
            ->map(function (EntidadRegistrada $e) {
                return [
                    "id" => $e->id,
                    "anio" => $e->anio,
                    "instrumento" => $e->instrumento,
                    "aprobado" => $e->aprobado,
                    "fecha_registrada" => $e->created_at->format('Y-m-d'),
                ];
            });
    }
}
