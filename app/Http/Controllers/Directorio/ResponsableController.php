<?php

namespace App\Http\Controllers\Directorio;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DataUbicacion;
use App\Models\Directorio\Responsable;
use App\Http\Requests\Directorio\ResponsableStoreRequest;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    use DataUbicacion;

    public function index(Request $request)
    {
        return Responsable::all();
    }

    public function store(ResponsableStoreRequest $request)
    {
        $data = $request->all();

        $entidad = new Responsable();
        $entidad->fill($data);
        $entidad->save();
        return $entidad;
    }

    public function show(Responsable $entidad)
    {
        return $entidad;
    }

    public function update(ResponsableStoreRequest $request, Responsable $responsable)
    {
        $responsable->update([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'dni' => $request->get('dni'),
            'email' => $request->get('email'),
            'telefono' => $request->get('telefono'),
            'fecha_inicio' => $request->get('fecha_inicio'),
            'fecha_fin' => $request->get('fecha_fin'),
            'fecha_registro' => $request->get('fecha_registro'),
            'cargo_id' => $request->get('id_cargo'),
            'roles_responsables_id' => $request->get('id_rol'),
        ]);
        return $responsable;
    }
}
