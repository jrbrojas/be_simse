<?php

namespace Database\Seeders\Csv;

use App\Models\Provincia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProvinciaImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Provincia
    {
        return new Provincia([
            'departamento_id' => $row['departamento_id'],
            'codigo' => $row['ubigeo'],
            'nombre' => $row['nombre'],
            'latitud' => $row['latitud'],
            'longitud' => $row['longitud'],
        ]);
    }
}
