<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TrabajoPublicado;

class TrabajoPublicadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TrabajoPublicado::create([
            'titulo' => 'Trabajo Publicado 1'
        ]);

        TrabajoPublicado::create([
            'titulo' => 'Trabajo Publicado 2'
        ]);

        TrabajoPublicado::create([
            'titulo' => 'Trabajo Publicado 3'
        ]);

        TrabajoPublicado::create([
            'titulo' => 'Trabajo Publicado 4'
        ]);

        TrabajoPublicado::create([
            'titulo' => 'Trabajo Publicado 5'
        ]);
    }
}
