<?php

namespace App\Http\Controllers\Directorio;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DataUbicacion;
use App\Models\Directorio\EntidadRegistrada;
use App\Models\Directorio\Responsable;
use App\Models\Entidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectorioController extends Controller
{
    use DataUbicacion;

    public function getEntidad(int $entidad)
    {
        $e = EntidadRegistrada::query()->with(['entidad', 'categoria'])->where('entidad_id', $entidad)->firstOrFail();
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
                'ubigeo.ubigeo',
                'entidades.nombre as nombre_entidad',
                'departamentos.nombre as departamento',
                'provs.nombre as provincia',
                'ubigeo.distrito as distrito',
                'categorias_responsables.nombre as categoria',
            )
            ->leftJoin('categorias_responsables', 'responsables.id_categoria', '=', 'categorias_responsables.id')
            ->leftJoin('ubigeo', 'responsables.ubigeo', '=', 'ubigeo.ubigeo')
            ->leftJoin('entidades', 'responsables.id_entidad', '=', 'entidades.id')
            ->leftJoin('depas', 'responsables.id_departamento', '=', 'depas.iddpto')
            ->leftJoin('provs', 'responsables.id_provincia', '=', 'provs.idprov')
            ->whereIn('responsables.id', $latestIds)
            ->get();
        return $responsables;
    }
}
