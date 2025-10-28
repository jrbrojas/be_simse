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
                'responsable.cargo',
                'responsable.roles_responsable',
                'entidad.distrito.provincia.departamento',
                'entidad.categoria',
                'historial_responsables.responsable',
            ])
            ->when(request()->get("q"), function ($query, $search) {
                $query->where(
                    fn($q) => $q
                        ->whereHas('entidad', function ($qe) use ($search) {
                            $qe->whereRaw('LOWER(nombre) LIKE ?', ["%{$search}%"]);
                        })
                        ->orWhereHas('responsable', function ($qr) use ($search) {
                            $qr->where('dni', 'like', "%{$search}%")
                                ->orWhereRaw(
                                    "LOWER(CONCAT(responsables.nombre, ' ', responsables.apellido)) LIKE ?",
                                    ["%{$search}%"],
                                );
                        })
                );
            })
            ->when(request()->get("entidad"), function ($query, $entidad) {
                $query->where('entidad_id', $entidad);
            })
            ->when(request()->get("distrito"), function ($query, $distrito) {
                $query->whereRelation('entidad', 'distrito_id', $distrito);
            })
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $responsable = Responsable::query()->create([
            'nombre' => request()->get('nombre'),
            'apellido' => request()->get('apellido'),
            'dni' => request()->get('dni'),
            'email' => request()->get('email'),
            'telefono' => request()->get('telefono'),
            'fecha_inicio' => request()->get('fecha_inicio'),
            'fecha_fin' => request()->get('fecha_fin'),
            'cargo_id' => request()->get('id_cargo'),
            'roles_responsables_id' => request()->get('id_rol'),
        ]);

        $directorio = Directorio::query()->firstOrNew([
            "entidad_id" => $request->get("id_entidad"),
        ]);

        $directorio->responsable_id = $responsable->id;
        $directorio->fecha_registro = $request->get('fecha_registro');
        $directorio->save();

        //$responsable = Responsable::query()->find($request->get("responsable_id"));

        HistorialResponsable::query()->create([
            "responsable_id" => $responsable->id,
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
            "entidad.distrito.provincia.departamento",
            "historial_responsables.responsable",
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
