<?php

namespace Database\Seeders;

use Database\Seeders\Csv\CentrosPobladosImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class CentrosPobladosImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = new CentrosPobladosImport();
        Excel::import($import, './database/seeders/Csv/centros_poblados.csv');
    }
}
