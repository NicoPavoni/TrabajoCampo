<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RevistaNacional;

class RevistaNacionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RevistaNacional::create([
            'pais'=> 'Pais 1',
            'editorial' => 'Editorial 1',
            'issn' => 'issn 1',
            'titulo_trabajo' => 'Titulo Trabajo 1',
            'con_referato' => '1',
            'documento_id' => '1'
        ]);

        RevistaNacional::create([
            'pais'=> 'Pais 2',
            'editorial' => 'Editorial 2',
            'issn' => 'issn 2',
            'titulo_trabajo' => 'Titulo Trabajo 2',
            'con_referato' => '0',
            'documento_id' => '2'
        ]);

        RevistaNacional::create([
            'pais'=> 'Pais 3',
            'editorial' => 'Editorial 3',
            'issn' => 'issn 3',
            'titulo_trabajo' => 'Titulo Trabajo 3',
            'con_referato' => '1',
            'documento_id' => '3'
        ]);

        RevistaNacional::create([
            'pais'=> 'Pais 4',
            'editorial' => 'Editorial 4',
            'issn' => 'issn 4',
            'titulo_trabajo' => 'Titulo Trabajo 4',
            'con_referato' => '0',
            'documento_id' => '4'
        ]);
    }
}
