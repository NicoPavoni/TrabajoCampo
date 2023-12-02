<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LibroCapitulo;
use App\Models\Documento;

class LibroCapituloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documento = Documento::create([
            'nombre' => 'Nombre Documento 1',
            'tipo_documento' => '1'
        ]);

        LibroCapitulo::create([
            'isbn' => 'isbn 1',
            'editorial' => 'Editorial 1',
            'nro_capitulo' => 'Nro Capitulo 1',
            'documento_id'=> $documento->id
        ]);

        $documento = Documento::create([
            'nombre' => 'Nombre Documento 2',
            'tipo_documento' => '1'
        ]);

        LibroCapitulo::create([
            'isbn' => 'isbn 2',
            'editorial' => 'Editorial 2',
            'nro_capitulo' => 'Nro Capitulo 2',
            'documento_id'=> $documento->id
        ]);

        $documento = Documento::create([
            'nombre' => 'Nombre Documento 3',
            'tipo_documento' => '1'
        ]);

        LibroCapitulo::create([
            'isbn' => 'isbn 3',
            'editorial' => 'Editorial 3',
            'nro_capitulo' => 'Nro Capitulo 3',
            'documento_id'=> $documento->id
        ]);

        $documento = Documento::create([
            'nombre' => 'Nombre Documento 4',
            'tipo_documento' => '1'
        ]);

        LibroCapitulo::create([
            'isbn' => 'isbn 4',
            'editorial' => 'Editorial 4',
            'nro_capitulo' => 'Nro Capitulo 4',
            'documento_id'=> $documento->id
        ]);
    }
}
