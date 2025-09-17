<?php

namespace App\Http\Controllers\Traits;

use App\Models\Entidad;
use App\Models\UbigeoPeruDepartment;
use App\Models\UbigeoPeruDistrict;
use App\Models\UbigeoPeruProvince;

trait DataUbicacion
{
    public function getDataUbicacion(int $id_entidad)
    {
        $entidad = Entidad::query()->find($id_entidad);
        $distrito = UbigeoPeruDistrict::query()->find($entidad->id_distrito);
        $provincia = UbigeoPeruProvince::query()->find($distrito->id_provincia);
        $departamento = UbigeoPeruDepartment::query()->find($provincia->id_departamento);
        $ubigeo = $distrito->codigo_ubigeo;
        $ids = [
            'id_entidad' => $entidad->id_entidad,
            'id_departemento' => $departamento->id_departamento,
            'id_provincia' => $provincia->id_provincia,
            'id_distrito' => $distrito->id_distrito,
            'ubigeo' => $distrito->codigo_ubigeo,
        ];
        return compact('entidad', 'distrito', 'provincia', 'departamento', 'ubigeo', 'ids');
    }
}
