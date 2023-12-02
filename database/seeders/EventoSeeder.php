<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Evento;

class EventoSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     */
    public function run(): void
    {
        Evento::create([
            'lugar' => 'Lugar 1',
            'fecha' => '2023-01-01',
            'nombre' => 'Nombre Evento 1',
            'descripcion' => 'Descripcion Evento 1'
        ]);

        Evento::create([
            'lugar' => 'Lugar 2',
            'fecha' => '2023-02-02',
            'nombre' => 'Nombre Evento 2',
            'descripcion' => 'Descripcion Evento 2'
        ]);

        Evento::create([
            'lugar' => 'Lugar 3',
            'fecha' => '2023-03-03',
            'nombre' => 'Nombre Evento 3',
            'descripcion' => 'Descripcion Evento 3'
        ]);

        Evento::create([
            'lugar' => 'Lugar 14',
            'fecha' => '2023-04-04',
            'nombre' => 'Nombre Evento 4',
            'descripcion' => 'Descripcion Evento 4'
        ]);
    }
}
