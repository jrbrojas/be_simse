<?php

namespace Database\Seeders\Csv;

use App\Models\Departamento;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartamentoImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Departamento
    {
        return new Departamento($row);
    }
}
