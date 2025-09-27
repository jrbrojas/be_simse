<?php

namespace App\Http\Controllers\Monitoreo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Monitoreo\RespuestaStore;
use App\Models\Monitoreo\EntidadRegistrada;
use App\Models\Monitoreo\RespuestasPreguntas;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MonitoreoController extends Controller
{
    public function index()
    {
        $ids = EntidadRegistrada::query()
            ->select(DB::raw('MAX(id) as max_id'))
            ->groupBy('entidad_id')
            ->get();
        $ids = $ids->pluck('max_id')->toArray();
        return EntidadRegistrada::with(['entidad', 'respuestas',
            'departamento',
            'provincia',
            'distrito'
        ])
            ->when(request()->get("categoria"), function ($query, $categoria) {
                $query->where('categoria_responsable_id', $categoria);
            })
            ->whereIn('id', $ids)->get();
    }
}
