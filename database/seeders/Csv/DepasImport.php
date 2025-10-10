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
        return new Depa($row);
    }
}
