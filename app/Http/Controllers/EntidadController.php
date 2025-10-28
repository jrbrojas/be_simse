<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Http\Requests\EntidadStoreRequest;
use Illuminate\Http\Request;

class EntidadController extends Controller
{
    public function index(Request $request)
    {
        return Entidad::query()
            ->with(['distrito'])
            ->when($request->get('ubigeo'), function ($query, $ubigeo) {
                $query->where('ubigeo', $ubigeo);
            })->get();
    }

    public function store(EntidadStoreRequest $request)
    {
        $data = $request->all();
        $entidad = new Entidad();
        $entidad->fill($data);
        $entidad->save();
        return $entidad;
    }

    public function show(Entidad $entidad)
    {
        return $entidad;
    }

    public function update(EntidadStoreRequest $request, Entidad $entidad)
    {
        $entidad->update($request->all());
        return $entidad;
    }

    public function destroy(Entidad $entidad)
    {
        $entidad->delete();
        return $entidad;
    }

    public function monitoreos(Entidad $entidad)
    {
        return $entidad->load([
            'monitoreos.monitoreo_respuestas.files',
        ]);
    }

    public function seguimientos(Entidad $entidad)
    {
        return $entidad->load([
            'seguimientos.seguimiento_respuestas.files',
        ]);
    }

    public function supervisiones(Entidad $entidad)
    {
        return $entidad->load([
            'supervisions.supervision_respuestas.files',
        ]);
    }
}
