<?php

namespace App\Http\Controllers\Directorio;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DataUbicacion;
use App\Models\Directorio\EntidadRegistrada;
use App\Models\Directorio\Responsable;
use App\Models\Entidad;
use App\Models\Prov;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectorioController extends Controller
{
    use DataUbicacion;

    public function getEntidad(int $entidad)
    {
        $e = EntidadRegistrada::query()
            ->with([
                'entidad.distrito',
                'entidad.provincia',
                'entidad.departamento',
                'categoria',
            ])->where('entidad_id', $entidad)->firstOrFail();
        return $e;
    }

    public function entidades()
    {
        return EntidadRegistrada::with(['entidad.distrito', 'categoria'])->get();
    }

    public function index()
    {
        $latestIds = DB::table('responsables as r')
            ->select(DB::raw('MAX(id) as id'))
            ->join(
                DB::raw('(SELECT id_entidad, MAX(fecha_fin) AS max_fecha FROM responsables GROUP BY id_entidad) m'),
                function ($join) {
                    $join->on('r.id_entidad', '=', 'm.id_entidad')
                         ->on('r.fecha_fin', '=', 'm.max_fecha');
                }
            )
            ->groupBy('r.id_entidad')
            ->pluck('id');
        $responsables = Responsable::query()
            ->select(
                'responsables.*',
                'entidades.ubigeo',
                'entidades.nombre as nombre_entidad',
                'departamentos.nombre as departamento',
                'provincias.nombre as provincia',
                'distritos.nombre as distrito',
                'categorias_responsables.nombre as categoria',
                'cargos_responsables.nombre as cargo',
                'roles_responsables.nombre as rol',
            )
            ->leftJoin('categorias_responsables', 'responsables.id_categoria', '=', 'categorias_responsables.id')
            ->leftJoin('distritos', 'responsables.id_distrito', '=', 'distritos.id')
            ->leftJoin('entidades', 'responsables.id_entidad', '=', 'entidades.id')
            ->leftJoin('departamentos', 'responsables.id_departamento', '=', 'departamentos.id')
            ->leftJoin('provincias', 'responsables.id_provincia', '=', 'provincias.id')
            ->leftJoin('cargos_responsables', 'cargos_responsables.id', '=', 'responsables.id_cargo')
            ->leftJoin('roles_responsables', 'roles_responsables.id', '=', 'responsables.id_rol')
            ->when(request('distrito'), function ($query, $distrito) {
                $query->where('responsables.id_distrito', $distrito);
            })
            ->when(request('categoria'), function ($query, $categoria) {
                $query->where('responsables.id_categoria', $categoria);
            })
            ->whereIn('responsables.id', $latestIds)
            ->get();
        return $responsables;
    }
}
