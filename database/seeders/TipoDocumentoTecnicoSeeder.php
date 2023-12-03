<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoDocumentoTecnico;

class TipoDocumentoTecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoDocumentoTecnico::create([
            'nombre' => 'Articulo de divulgacion'
        ]);

        TipoDocumentoTecnico::create([
            'nombre' => 'Informe'
        ]);

        TipoDocumentoTecnico::create([
            'nombre' => 'Memoria Tecnica'
        ]);
    }
}
