<?php

namespace Database\Seeders;

use Database\Seeders\Csv\DistritoImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DistritosImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = new DistritoImport();
        Excel::import($import, './database/seeders/Csv/distritos.csv');
    }
}
