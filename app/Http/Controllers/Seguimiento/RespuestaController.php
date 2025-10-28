<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Models\Seguimiento\Seguimiento;
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

    public function exportPdf(Seguimiento $seguimiento)
    {
        $data = $seguimiento->load([
            'seguimiento_respuestas.files',
            'entidad.distrito.provincia.departamento',
            'entidad.categoria',
        ]);

        // agrupamos las respuestas por OP
        $respuestasAgrupadas = $data->seguimiento_respuestas->groupBy('instrumento');

        $pdf = Pdf::loadView('pdf.seguimiento_reporte', [
            'data' => $data,
            'respuestasAgrupadas' => $respuestasAgrupadas
        ])
        ->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_entidad_{$seguimiento->entidad_id}.pdf");
    }
}
