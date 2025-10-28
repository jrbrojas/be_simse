<?php

namespace Database\Seeders;

use Database\Seeders\Csv\ProvinciaImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ProvinciasImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = new ProvinciaImport();
        Excel::import($import, './database/seeders/Csv/provincias.csv');
    }
}
