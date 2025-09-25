<?php

namespace Database\Seeders\Csv;

use App\Models\Depa;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepasImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Depa
    {
        $d = new Depa([
            "iddpto" => $row['iddpto'],
            "nombre" => $row['nombdpto'],
            "capital" => $row['capital'],
        ]);
        $d->created_at = Carbon::now();
        $d->updated_at = Carbon::now();
        return $d;
    }
}
