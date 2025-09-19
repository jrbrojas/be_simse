<?php

namespace Database\Seeders;

use Database\Seeders\Csv\ProvsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ProvsImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = new ProvsImport();
        Excel::import($import, './database/seeders/Csv/provs.csv');
    }
}
