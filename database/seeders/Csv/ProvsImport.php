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
        return new Prov($row);
    }
}
