<?php

namespace App\Http\Controllers\Directorio;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DataUbicacion;
use App\Models\Directorio\CargoResponsable;
use App\Models\Directorio\CategoriaResponsable;
use App\Models\Directorio\EntidadRegistrada;
use App\Models\Directorio\Responsable;
use App\Http\Requests\Directorio\ResponsableStoreRequest;
use App\Models\Directorio\RolResponsable;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        return Responsable::query()
            ->select(
                'responsables.*',
                'roles_responsables.nombre as rol',
                'cargos_responsables.nombre as cargo',
            )
            ->when($request->get('id_entidad'), function ($query, $id) {
                $query->where('id_entidad', $id);
            })
            ->with([
                'distrito',
                'provincia',
                'departamento',
            ])
            ->leftJoin('roles_responsables', 'responsables.id_rol', '=', 'roles_responsables.id')
            ->leftJoin('cargos_responsables', 'responsables.id_cargo', '=', 'cargos_responsables.id')
            ->orderBy('responsables.fecha_fin', 'DESC')
            ->get();
    }

    public function store(ResponsableStoreRequest $request)
    {
        $data = $request->all();
        $first = EntidadRegistrada::firstOrNew(['entidad_id' => $data['id_entidad']]);
        $first->categoria_id = $data['id_categoria'];
        $first->fecha_registro = $data['fecha_registro'];
        $first->save();

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
        //$ids = $this->getDataUbicacion($data['id_entidad'])['ids'];
        $ids = [
            'id_entidad' => $request->get("id_entidad"),
            'id_departemento' => $request->get("id_departamento"),
            'id_provincia' => $request->get("id_provincia"),
            'ubigeo' => $request->get("ubigeo"),
        ];
        $data['id_departemento'] = $ids['id_departemento'];
        $data['id_provincia'] = $ids['id_provincia'];
        $data['ubigeo'] = $ids['ubigeo'];
        $responsable->update($data);
        return $responsable;
    }

    public function destroy(Responsable $entidad)
    {
        $entidad->delete();
        return $entidad;
    }
}
