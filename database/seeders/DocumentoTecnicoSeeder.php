<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentoTecnico;
use App\Models\Documento;

class DocumentoTecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documento = Documento::create([
            'nombre' => 'Nombre Documento 1',
            'tipo_documento' => '4'
        ]);

        DocumentoTecnico::create([
            'lugar' => 'Lugar 1',
            'fecha' => '2023-01-01',
            'documento_id' => '1',
            'tipo_documento_tecnico_id' => $documento->id
        ]);

        $documento = Documento::create([
            'nombre' => 'Nombre Documento 2',
            'tipo_documento' => '4'
        ]);

        DocumentoTecnico::create([
            'lugar' => 'Lugar 2',
            'fecha' => '2023-01-02',
            'documento_id' => '2',
            'tipo_documento_tecnico_id' => $documento->id
        ]);

        $documento = Documento::create([
            'nombre' => 'Nombre Documento 3',
            'tipo_documento' => '4'
        ]);

        DocumentoTecnico::create([
            'lugar' => 'Lugar 3',
            'fecha' => '2023-01-03',
            'documento_id' => '3',
            'tipo_documento_tecnico_id' => $documento->id
        ]);

        $documento = Documento::create([
            'nombre' => 'Nombre Documento 4',
            'tipo_documento' => '4'
        ]);

        DocumentoTecnico::create([
            'lugar' => 'Lugar 4',
            'fecha' => '2023-01-04',
            'documento_id' => '4',
            'tipo_documento_tecnico_id' => $documento->id
        ]);
    }
}
