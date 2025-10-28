<?php

namespace App\Http\Controllers\Supervision;

use App\Http\Controllers\Controller;
use App\Models\Supervision\Supervision;
use App\Models\Supervision\SupervisionRespuesta;
use Barryvdh\DomPDF\Facade\Pdf;

class RespuestaController extends Controller
{
    public function index()
    {
        return SupervisionRespuesta::with('files')
            ->when(request()->get("entidad_id"), function ($query, $id) {
                $query->where('entidad_id', $id);
            })
            ->get();
    }

    public function exportPdf(Supervision $supervision)
    {
        $data = $supervision->load([
            'supervision_respuestas.files',
            'entidad.distrito.provincia.departamento',
            'entidad.categoria',
        ]);

        $respuestasAgrupadas = $data->supervision_respuestas->groupBy('nombre');

        $pdf = Pdf::loadView('pdf.supervision_reporte', [
            'data' => $data,
            'respuestasAgrupadas' => $respuestasAgrupadas
        ])
        ->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_entidad_{$supervision->entidad_id}.pdf");
    }
}
