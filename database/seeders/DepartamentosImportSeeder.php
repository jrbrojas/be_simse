<?php

namespace Database\Seeders;

use Database\Seeders\Csv\DepartamentoImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DepartamentosImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = new DepartamentoImport();
        Excel::import($import, './database/seeders/Csv/departamentos.csv');
    }
}
