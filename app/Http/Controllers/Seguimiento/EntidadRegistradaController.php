<?php

namespace App\Http\Controllers\Seguimiento;

//use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Seguimiento\EntidadRegistrada;

class EntidadRegistradaController extends Controller
{
    public function getEntidad(int $entidad)
    {
        $e = EntidadRegistrada::query()
            ->with([
                'entidad',
                'categoria',
                'departamento',
                'provincia',
                'distrito',
            ])
            ->where('id', $entidad)
            ->firstOrFail();
        return $e;
    }

    /*
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

        // agrupamos las respuestas por OP
        $respuestasAgrupadas = $data->respuestas->groupBy('op');

        $pdf = Pdf::loadView('pdf.monitoreo_reporte', [
            'data' => $data,
            'respuestasAgrupadas' => $respuestasAgrupadas
        ])
        ->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_entidad_{$entidad}.pdf");
    }
    */

    public function historial(EntidadRegistrada $entidad)
    {
        return EntidadRegistrada::query()
            ->where('entidad_id', $entidad->entidad_id)
            ->get()
            ->map(function (EntidadRegistrada $e) {
                return [
                    "id" => $e->id,
                    "fecha_registrada" => $e->created_at->format('Y-m-d'),
                ];
            });
    }
}
