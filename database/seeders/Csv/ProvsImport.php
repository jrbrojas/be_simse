<?php

namespace Database\Seeders\Csv;

use App\Models\Prov;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProvsImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Prov
    {
        $p = new Prov([
            "idprov" => $row['idprov'],
            "nombre" => $row['nombprov'],
            "nomdpto" => $row['nomdpto'],
        ]);
        $p->created_at = Carbon::now();
        $p->updated_at = Carbon::now();
        return $p;
    }
}
