<?php

namespace Database\Seeders;

use Database\Seeders\Csv\DepasImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DepasImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = new DepasImport();
        Excel::import($import, './database/seeders/Csv/depas.csv');
    }
}
