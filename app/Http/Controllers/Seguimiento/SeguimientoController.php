<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Models\Seguimiento\EntidadRegistrada;
use Illuminate\Support\Facades\DB;

class SeguimientoController extends Controller
{
    public function index()
    {
        // Obtenemos el último registro por entidad_id
        $ids = EntidadRegistrada::query()
            ->select(DB::raw('MAX(id) as max_id'))
            ->groupBy('entidad_id')
            ->pluck('max_id')
            ->toArray();

        // Devolvemos las entidades con sus relaciones
        return EntidadRegistrada::with([
            'entidad',
            'categoria',
            'departamento',
            'respuestas',
            'provincia',
            'distrito',
            'file'
        ])
        ->whereIn('id', $ids)
        ->get();
    }

    public function show(int $id)
    {
        return EntidadRegistrada::with([
            'entidad',
            'categoria',
            'departamento',
            'provincia',
            'respuestas',
            'distrito',
            'file'
        ])->findOrFail($id);
    }
}
