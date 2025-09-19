<?php

namespace Database\Seeders\Csv;

use App\Models\Prov;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProvsImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Prov
    {
        return new Prov([
            "idprov" => $row['idprov'],
            "nombre" => $row['nombprov'],
            "nomdpto" => $row['nomdpto'],
        ]);
    }
}
