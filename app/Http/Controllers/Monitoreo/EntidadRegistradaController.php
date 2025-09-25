<?php

namespace App\Http\Controllers\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\Monitoreo\EntidadRegistrada;
use Barryvdh\DomPDF\Facade\Pdf;


class EntidadRegistradaController extends Controller
{
    public function getEntidad(int $entidad)
    {
        $e = EntidadRegistrada::query()->with(['entidad', 'categoria'])->where('id', $entidad)->firstOrFail();
        return $e;
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

        // agrupamos las respuestas por OP
        $respuestasAgrupadas = $data->respuestas->groupBy('op');

        $pdf = Pdf::loadView('pdf.monitoreo_reporte', [
            'data' => $data,
            'respuestasAgrupadas' => $respuestasAgrupadas
        ])
        ->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_entidad_{$entidad}.pdf");
}

}

