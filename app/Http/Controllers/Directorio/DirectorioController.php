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
                DB::raw('(SELECT ubigeo, MAX(fecha_fin) AS max_fecha FROM responsables GROUP BY ubigeo) m'),
                function ($join) {
                    $join->on('r.ubigeo', '=', 'm.ubigeo')
                         ->on('r.fecha_fin', '=', 'm.max_fecha');
                }
            )
            ->groupBy('r.ubigeo')
            ->pluck('id');
        $responsables = Responsable::query()
            ->select(
                'responsables.*',
                'distritos.ubigeo',
                'entidades.nombre as nombre_entidad',
                'departamentos.nombre as departamento',
                'provincias.nombre as provincia',
                'distritos.distrito as distrito',
                'categorias_responsables.nombre as categoria',
            )
            ->leftJoin('categorias_responsables', 'responsables.id_categoria', '=', 'categorias_responsables.id')
            ->leftJoin('distritos', 'responsables.ubigeo', '=', 'distritos.ubigeo')
            ->leftJoin('entidades', 'responsables.id_entidad', '=', 'entidades.id')
            ->leftJoin('departamentos', 'responsables.id_departamento', '=', 'departamentos.iddpto')
            ->leftJoin('provincias', 'responsables.id_provincia', '=', 'provincias.idprov')
            ->whereIn('responsables.id', $latestIds)
            ->get();
        return $responsables;
    }
}
