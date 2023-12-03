<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ArticuloConReferato;
use App\Models\Documento;

class ArticuloConReferatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documento = Documento::create([
            'nombre' => 'Nombre Documento 1',
            'tipo_documento' => '3'
        ]);

        ArticuloConReferato::create([
            'lugar' => 'Ciudad 1',
            'fecha' => '2023-01-01',
            'es_nacional' => '1',
            'documento_id' => $documento->id
        ]);

        $documento = Documento::create([
            'nombre' => 'Nombre Documento 2',
            'tipo_documento' => '3'
        ]);

        ArticuloConReferato::create([
            'lugar' => 'Pais 1',
            'fecha' => '2023-12-12',
            'es_nacional' => '0',
            'documento_id' => $documento->id
        ]);

        $documento = Documento::create([
            'nombre' => 'Nombre Documento 3',
            'tipo_documento' => '3'
        ]);

        ArticuloConReferato::create([
            'lugar' => 'Ciudad 2',
            'fecha' => '2023-10-10',
            'es_nacional' => '1',
            'documento_id' => $documento->id
        ]);

        $documento = Documento::create([
            'nombre' => 'Nombre Documento 4',
            'tipo_documento' => '3'
        ]);

        ArticuloConReferato::create([
            'lugar' => 'Pais 2',
            'fecha' => '2023-11-11',
            'es_nacional' => '0',
            'documento_id' => $documento->id
        ]);
    }
}
