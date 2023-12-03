<?php

namespace Database\Seeders;

use App\Models\Institucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institucion::create([
            'tipo' => 'Universidad',
            'nombre' => 'UTN'
        ]);

        Institucion::create([
            'tipo' => 'Universidad',
            'nombre' => 'UNLP'
        ]);

        Institucion::create([
            'tipo' => 'Empresa',
            'nombre' => 'Mercado Libre'
        ]);

        Institucion::create([
            'tipo' => 'Empresa',
            'nombre' => 'Accenture'
        ]);

        Institucion::create([
            'tipo' => 'ONG',
            'nombre' => 'Unicef'
        ]);
    }
}
