<?php

namespace App\Http\Controllers\Directorio;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DataUbicacion;
use App\Models\Directorio\CargoResponsable;
use App\Models\Directorio\Responsable;
use App\Http\Requests\Directorio\ResponsableStoreRequest;
use App\Models\Directorio\RolResponsable;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    use DataUbicacion;

    public function roles()
    {
        return RolResponsable::all();
    }

    public function cargos()
    {
        return CargoResponsable::all();
    }

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
        $data = $request->all();
        $responsable->update($data);
        return $responsable;
    }
}
