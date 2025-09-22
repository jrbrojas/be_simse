<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepasImportSeeder::class,
            ProvsImportSeeder::class,
            UbigeoImportSeeder::class,
            EntidadesImportSeeder::class,
            RolesSeeder::class,
            UserSeeder::class,
            CargosResponsablesSeeder::class,
            CategoriasResponsablesSeeder::class,
            RolesResponsablesSeeder::class,
        ]);
    }
}
