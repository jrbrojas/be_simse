<?php

namespace App\Http\Controllers\Seguimiento;

use Barryvdh\DomPDF\Facade\Pdf;
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
            "entidad_id" => $e->entidad_id,
            "entidad" => $e->entidad,
            "categoria" => $e->categoria,
            "departamento" => $e->departamento,
            "provincia" => $e->provincia,
            "distrito" => $e->distrito,
            "ubigeo" => $e->ubigeo,
            "anio" => $e->anio,
            "respuestas" => $e->respuestas,
            "created_at" => $e->created_at->format('Y-m-d H:i:s'),
        ]);
    }

    public function exportPdf(int $entidad)
    {
        $data = EntidadRegistrada::with([
            'entidad',
            'categoria',
            'departamento',
            'provincia',
            'distrito',
            'respuestas'
        ])->findOrFail($entidad);

        //$respuestasAgrupadas = $data->respuestas->groupBy('instrumento');

        $pdf = Pdf::loadView('pdf.seguimiento_reporte', [
            'data' => $data,
            'respuestasAgrupadas' => $data
        ])
        ->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_entidad_{$entidad}.pdf");
    }

    public function historial(EntidadRegistrada $entidad)
    {
        return EntidadRegistrada::query()
            ->where('entidad_id', $entidad->entidad_id)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function (EntidadRegistrada $e) {
                return [
                    "id" => $e->id,
                    "anio" => $e->anio,
                    "fecha_registrada" => $e->created_at->format('Y-m-d'),
                ];
            });
    }
}
