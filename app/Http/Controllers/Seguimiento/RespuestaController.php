<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Models\Monitoreo\Monitoreo;
use App\Models\Seguimiento\SeguimientoRespuesta;
use Barryvdh\DomPDF\Facade\Pdf;

class RespuestaController extends Controller
{
    public function index()
    {
        return SeguimientoRespuesta::with('files')
            ->when(request()->get("entidad_id"), function ($query, $id) {
                $query->where('entidad_id', $id);
            })
            ->get();
    }

    public function exportPdf(int $entidad)
    {
        $data = SeguimientoRespuesta::with([
            'entidad.distrito.provincia.departamento',
            'files',
        ])->where("entidad_id", $entidad)->findOrFail($entidad);

        //$respuestasAgrupadas = $data->respuestas->groupBy('instrumento');

        $pdf = Pdf::loadView('pdf.seguimiento_reporte', [
            'data' => $data,
            'respuestasAgrupadas' => $data
        ])
        ->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_entidad_{$entidad}.pdf");
    }
}
