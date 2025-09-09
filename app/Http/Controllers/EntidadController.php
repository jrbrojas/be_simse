<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Http\Requests\EntidadStoreRequest;
use Illuminate\Http\Request;

class EntidadController extends Controller
{
    public function index()
    {
        return Entidad::all();
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
}
