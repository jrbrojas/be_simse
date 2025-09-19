<?php

namespace Database\Seeders;

use Database\Seeders\Csv\UbigeosImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class UbigeoImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = new UbigeosImport();
        Excel::import($import, './database/seeders/Csv/ubigeo.csv');
    }
}
