<?php

namespace Database\Seeders;

use App\Models\Directorio\RolesResponsable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesResponsablesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nombre' => 'Responsable de GRD'],
            ['nombre' => 'Autoridad'],
        ];
        RolesResponsable::query()->insert($data);
    }
}
