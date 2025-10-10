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
            DepasImportSeeder::class,
            ProvsImportSeeder::class,
            UbigeoImportSeeder::class,
            EntidadesImportSeeder::class,
            //CentrosPobladosImportSeeder::class,
        ]);
    }
}
