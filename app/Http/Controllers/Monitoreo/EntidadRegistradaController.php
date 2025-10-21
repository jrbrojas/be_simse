<?php

namespace App\Http\Controllers\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\Monitoreo\EntidadRegistrada;
use App\Models\Monitoreo\Monitoreo;
use App\Models\Monitoreo\MonitoreoRespuesta;
use Barryvdh\DomPDF\Facade\Pdf;

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
                'file',
            ])
            ->where('id', $entidad)
            ->firstOrFail();
        $e->file_url = "";
        if ($e->file) {
            $data = ['type' => 'monitoreo', 'id' => $e->file->id];
            $e->file_url = route('anyfiles.show', $data);
        }
        return $e;
    }

    public function exportPdf(int $entidad)
    {
        $data = Monitoreo::with([
            'files',
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

    public function historial(EntidadRegistrada $entidad)
    {
        return EntidadRegistrada::query()
            ->where('entidad_id', $entidad->entidad_id)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function (EntidadRegistrada $e) {
                return [
                    "id" => $e->id,
                    "fecha_registrada" => $e->created_at->format('Y-m-d'),
                ];
            });
    }
}

