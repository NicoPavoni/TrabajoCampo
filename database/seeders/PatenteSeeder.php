<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patente;

class PatenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patente::create([
            'fecha_presentacion' => '2023-01-01',
            'titulo' => 'Titulo Patente 1',
            'registro_propiedad_id' => '1'
        ]);

        Patente::create([
            'fecha_presentacion' => '2023-02-02',
            'titulo' => 'Titulo Patente 2',
            'registro_propiedad_id' => '2'
        ]);

        Patente::create([
            'fecha_presentacion' => '2023-03-03',
            'titulo' => 'Titulo Patente 3',
            'registro_propiedad_id' => '3'
        ]);

        Patente::create([
            'fecha_presentacion' => '2023-04-04',
            'titulo' => 'Titulo Patente 4',
            'registro_propiedad_id' => '4'
        ]);
    }
}
