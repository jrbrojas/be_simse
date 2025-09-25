<?php

namespace Database\Seeders\Csv;

use App\Models\Entidad;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EntidadesImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Entidad
    {
        unset($row['id']);

        $e = new Entidad($row);
        $e->created_at = Carbon::now();
        $e->updated_at = Carbon::now();
        return $e;
    }
}
