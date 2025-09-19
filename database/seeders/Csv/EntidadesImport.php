<?php

namespace Database\Seeders\Csv;

use App\Models\Entidad;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EntidadesImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Entidad
    {
        unset($row['id']);
        return new Entidad($row);
    }
}
