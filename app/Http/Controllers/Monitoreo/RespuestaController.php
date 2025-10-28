<?php

namespace App\Http\Controllers\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\Monitoreo\Monitoreo;
use App\Models\Monitoreo\MonitoreoRespuesta;
use Barryvdh\DomPDF\Facade\Pdf;

class RespuestaController extends Controller
{
    public function index()
    {
        return MonitoreoRespuesta::with('files')
            ->when(request()->get("entidad_id"), function ($query, $id) {
                $query->where('entidad_id', $id);
            })
            ->get();
    }

    public function exportPdf(Monitoreo $monitoreo)
    {
        $data = $monitoreo->load([
            'monitoreo_respuestas.files',
            'entidad.distrito.provincia.departamento',
            'entidad.categoria',
        ]);

        // agrupamos las respuestas por OP
        $respuestasAgrupadas = $data->monitoreo_respuestas->groupBy('op');

        $pdf = Pdf::loadView('pdf.monitoreo_reporte', [
            'data' => $data,
            'respuestasAgrupadas' => $respuestasAgrupadas
        ])
        ->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_entidad_{$monitoreo->entidad->id}.pdf");
    }
}
