<?php

namespace Database\Seeders\Csv;

use App\Models\Directorio\CategoriaResponsable;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriaResponsableImport implements ToModel, WithHeadingRow
{
    public function model(array $row): CategoriaResponsable
    {

        $u = new CategoriaResponsable([
            "nombre" => $row['v_destiporg'],
            "abrev" => $row['v_abrev'],
        ]);
        $u->created_at = Carbon::now();
        $u->updated_at = Carbon::now();
        return $u;
    }
}
