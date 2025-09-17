<?php

namespace Database\Seeders;

use App\Models\Directorio\CargoResponsable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargosResponsablesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nombre' => 'Director'],
            ['nombre' => 'Gerente'],
            ['nombre' => 'Jefe'],
            ['nombre' => 'Coordinador'],
            ['nombre' => 'Especialista'],
            ['nombre' => 'Analista'],
            ['nombre' => 'Asistente'],
        ];
        CargoResponsable::query()->insert($data);
    }
}
