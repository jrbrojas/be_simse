<?php

namespace App\Http\Controllers\Supervision;

use App\Http\Controllers\Controller;
use App\Models\Supervision\Supervision;
use App\Models\Supervision\SupervisionEntidadRegistrada;
use App\Models\Supervision\SupervisionRespuesta;
use App\Models\Supervision\SupervisionSeccion;
use App\Models\Supervision\SupervisionItem;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SupervisionController extends Controller
{
    public function tabla()
    {
        $ids = Supervision::query()
            ->when(request()->get("categoria"), function ($query, $categoria) {
                $query->whereRelation('entidad', 'categoria_id', $categoria);
            })
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('entidad_id')
            ->get()
            ->pluck('id');

        if ($ids->isEmpty()) {
            return [];
        }

        return Supervision::with([
                'entidad.distrito.provincia.departamento',
                'entidad.categoria',
                'supervision_respuestas',
            ])
            ->whereIn('id', $ids)
            ->get();
    }

    public function index()
    {
        return Supervision::with('entidad.distrito.provincia.departamento')
            ->when(request()->get("categoria"), function ($query, $categoria) {
                $query->where('categoria_id', $categoria);
            })
            ->get();
    }

    public function store(Request $request)
    {
        $supervision = Supervision::query()->create([
            'entidad_id'              => $request->input('entidad_id'),
            'promedio_final'          => $request->input('promedio_final'),
            'anio'                    => $request->input('anio'),
        ]);

        $respuestas = $request->all()['respuestas'] ?? [];

        foreach ($respuestas as $respuesta) {
            $supervisionRespuesta = SupervisionRespuesta::query()->create([
                'supervision_id' => $supervision->id,
                'nombre'   => $respuesta['nombre']   ?? 'Sin nombre',
                'respuesta' => strtolower($respuesta['respuesta'] ?? 'no'),
                'promedio' => $respuesta['promedio'] ?? 0,
            ]);

            $uploaded = $respuesta['file'] ?? [];
            $files = collect([]);
            if (is_array($uploaded) && !empty($uploaded)) {
                foreach ($uploaded as $item) {
                    /** @var UploadedFile $file */
                    $file = $item['file'];
                    if ($file) {
                        $path     = $file->store('supervision/files');

                        $files->push([
                            'name'        => $file->getClientOriginalName(),
                            'path'        => $path,
                            'disk'        => 'local',
                            'size'        => $file->getSize(),
                            'mime_type'   => $file->getClientMimeType(),
                            'descripcion' => $item['descripcion'] ?? null,
                            'aprobado'    => null,
                            'porcentaje' => $item['porcentaje'] ?? 0,
                        ]);
                    }
                }
            }
            $supervisionRespuesta->files()->createMany($files->toArray());
        }

        return $supervision->load([
            'entidad.distrito.provincia.departamento',
            'supervision_respuestas.files',
        ]);
    }

    public function show(Supervision $supervision)
    {
        return $supervision->load([
            'entidad.categoria',
            'entidad.distrito.provincia.departamento',
            'supervision_respuestas.files'
        ]);
    }
}


