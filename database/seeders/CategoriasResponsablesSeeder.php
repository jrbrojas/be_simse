<?php

namespace Database\Seeders;

use App\Models\Directorio\CategoriaResponsable;
use Database\Seeders\Csv\CategoriaImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CategoriasResponsablesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = new CategoriaImport();
        Excel::import($import, './database/seeders/Csv/cntbc_tiporganismo.csv');
    }
}
