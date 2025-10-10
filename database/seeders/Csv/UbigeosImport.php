<?php

namespace Database\Seeders\Csv;

use App\Models\Ubigeo;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UbigeosImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Ubigeo
    {
        return new Ubigeo($row);
    }
}
