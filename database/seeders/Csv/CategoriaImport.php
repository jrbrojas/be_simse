<?php

namespace Database\Seeders\Csv;

use App\Models\Directorio\Categoria;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriaImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Categoria
    {

        $u = new Categoria([
            "nombre" => $row['v_destiporg'],
            "abreviatura" => $row['v_abrev'],
        ]);
        $u->created_at = Carbon::now();
        $u->updated_at = Carbon::now();
        return $u;
    }
}
