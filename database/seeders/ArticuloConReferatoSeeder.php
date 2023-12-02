<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ArticuloConReferato;

class ArticuloConReferatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ArticuloConReferato::create([
            'lugar' => 'Ciudad 1',
            'fecha' => '2023-01-01',
            'es_nacional' => '1',
            'documento_id' => '1'
        ]);

        ArticuloConReferato::create([
            'lugar' => 'Pais 1',
            'fecha' => '2023-12-12',
            'es_nacional' => '0',
            'documento_id' => '2'
        ]);

        ArticuloConReferato::create([
            'lugar' => 'Ciudad 2',
            'fecha' => '2023-10-10',
            'es_nacional' => '1',
            'documento_id' => '3'
        ]);

        ArticuloConReferato::create([
            'lugar' => 'Pais 2',
            'fecha' => '2023-11-11',
            'es_nacional' => '0',
            'documento_id' => '4'
        ]);
    }
}
