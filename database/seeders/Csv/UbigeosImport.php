<?php

namespace Database\Seeders\Csv;

use App\Models\Ubigeo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UbigeosImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Ubigeo
    {
        return new Ubigeo([
            "ubigeo" => $row['ubigeo'],
            "distrito" => $row['nombdist'],
            "departamento" => $row['nombdpto'],
            "provincia" => $row['nombprov'],
            "iddpto" => $row['iddpto'],
            "idprov" => $row['idprov'],
            "capital" => $row['capital'],
        ]);
    }
}
