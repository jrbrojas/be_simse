<?php

namespace Database\Seeders\Csv;

use App\Models\Distrito;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistritoImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Distrito
    {
        return new Distrito([
            'provincia_id' => $row['provincia_id'],
            'codigo' => $row['ubigeo'],
            'nombre' => $row['nombre'],
        ]);
    }
}
