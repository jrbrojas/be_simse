<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntidadesYCentrosPoblados extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            DepartamentosImportSeeder::class,
            ProvinciasImportSeeder::class,
            DistritosImportSeeder::class,
            EntidadesImportSeeder::class,
            CentrosPobladosImportSeeder::class,
        ]);
    }
}
