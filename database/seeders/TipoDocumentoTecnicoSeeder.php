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
            'nombre' => 'Artículo de divulgación'
        ]);

        TipoDocumentoTecnico::create([
            'nombre' => 'Informe'
        ]);

        TipoDocumentoTecnico::create([
            'nombre' => 'Memoria Técnica'
        ]);
    }
}
