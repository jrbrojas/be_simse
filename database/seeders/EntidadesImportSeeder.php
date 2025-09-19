<?php

namespace Database\Seeders;

use Database\Seeders\Csv\EntidadesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class EntidadesImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = new EntidadesImport();
        Excel::import($import, './database/seeders/Csv/entidades.csv');
    }
}
