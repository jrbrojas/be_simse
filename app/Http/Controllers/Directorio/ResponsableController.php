<?php

namespace App\Http\Controllers\Directorio;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DataUbicacion;
use App\Models\Directorio\CargoResponsable;
use App\Models\Directorio\CategoriaResponsable;
use App\Models\Directorio\Responsable;
use App\Http\Requests\Directorio\ResponsableStoreRequest;
use App\Models\Directorio\RolResponsable;

class ResponsableController extends Controller
{
    use DataUbicacion;

    public function categorias()
    {
        return CategoriaResponsable::all();
    }

    public function roles()
    {
        return RolResponsable::all();
    }

    public function cargos()
    {
        return CargoResponsable::all();
    }

    public function index()
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

    public function update(ResponsableStoreRequest $request, Responsable $entidad)
    {
        $data = $request->all();
        $ids = $this->getDataUbicacion($data['id_entidad'])['ids'];
        $data['id_departemento'] = $ids['id_departemento'];
        $data['id_distrito'] = $ids['id_distrito'];
        $data['id_provincia'] = $ids['id_provincia'];
        $data['ubigeo'] = 0; //$ids['ubigeo'];
        $entidad->update($data);
        return $entidad;
    }

    public function destroy(Responsable $entidad)
    {
        $entidad->delete();
        return $entidad;
    }
}
