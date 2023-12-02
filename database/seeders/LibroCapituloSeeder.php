<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LibroCapitulo;

class LibroCapituloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibroCapitulo::create([
            'isbn' => 'isbn 1',
            'editorial' => 'Editorial 1',
            'nro_capitulo' => 'Nro Capitulo 1',
            'documento_id'=> '1'
        ]);

        LibroCapituloo::create([
            'isbn' => 'isbn 2',
            'editorial' => 'Editorial 2',
            'nro_capitulo' => 'Nro Capitulo 2',
            'documento_id'=> '2'
        ]);

        LibroCapituloo::create([
            'isbn' => 'isbn 3',
            'editorial' => 'Editorial 3',
            'nro_capitulo' => 'Nro Capitulo 3',
            'documento_id'=> '3'
        ]);

        LibroCapituloo::create([
            'isbn' => 'isbn 4',
            'editorial' => 'Editorial 4',
            'nro_capitulo' => 'Nro Capitulo 4',
            'documento_id'=> '4'
        ]);
    }
}
