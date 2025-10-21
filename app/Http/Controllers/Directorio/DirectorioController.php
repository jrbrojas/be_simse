<?php

namespace App\Http\Controllers\Directorio;

use App\Http\Controllers\Controller;
use App\Models\Directorio\Directorio;
use App\Models\Directorio\HistorialResponsable;
use App\Models\Directorio\Responsable;
use Illuminate\Http\Request;

class DirectorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Directorio::query()
            ->with([
                'responsable',
            ])
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $directorio = Directorio::query()->create([
            "fecha_registro" => $request->get("fecha_registro"),
            "responsable_id" => $request->get("responsable_id"),
            "entidad_id" => $request->get("entidad_id"),
        ]);

        $responsable = Responsable::query()->find($request->get("responsable_id"));

        HistorialResponsable::query()->create([
            "responsable_id" => $request->get("responsable_id"),
            "directorio_id" => $directorio->id,
            "fecha_inicio" => $responsable->fecha_inicio,
            "fecha_fin" => $responsable->fecha_fin,
        ]);

        return [
            "message" => "Directorio creado",
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Directorio $directorio)
    {
        return $directorio->load([
            "responsable",
            "entidad.distrito.provincia.departamento"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Directorio $directorio)
    {
        $directorio->update([
            "responsable_id" => $request->get("responsable_id"),
        ]);

        return $directorio;
    }
}
