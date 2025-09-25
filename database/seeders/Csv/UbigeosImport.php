<?php

namespace Database\Seeders\Csv;

use App\Models\Ubigeo;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UbigeosImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Ubigeo
    {
        $u = new Ubigeo([
            "ubigeo" => $row['ubigeo'],
            "distrito" => $row['nombdist'],
            "departamento" => $row['nombdpto'],
            "provincia" => $row['nombprov'],
            "iddpto" => $row['iddpto'],
            "idprov" => $row['idprov'],
            "capital" => $row['capital'],
        ]);
        $u->created_at = Carbon::now();
        $u->updated_at = Carbon::now();
        return $u;
    }
}
