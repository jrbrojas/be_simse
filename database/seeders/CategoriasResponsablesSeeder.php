<?php

namespace Database\Seeders;

use App\Models\Directorio\CategoriaResponsable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriasResponsablesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nombre' => 'Entidades del Poder Legislativo'],
            ['nombre' => 'Ministerios'],
            ['nombre' => 'Gobiernos Regionales'],
            ['nombre' => 'Gobiernos Provinciales'],
            ['nombre' => 'Gobiernos Distritales'],
            ['nombre' => 'Universidades Públicas'],
            ['nombre' => 'Universidades Privadas'],
            ['nombre' => 'Escuelas Superiores de las FFA'],
            ['nombre' => 'Otras entidades'],
        ];

        CategoriaResponsable::query()->insert($data);
    }
}
