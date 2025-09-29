<?php

namespace Database\Seeders;

use App\Models\Directorio\CategoriaResponsable;
use Database\Seeders\Csv\CategoriaResponsableImport;
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
        $import = new CategoriaResponsableImport();
        Excel::import($import, './database/seeders/Csv/cntbc_tiporganismo.csv');
    }
}
