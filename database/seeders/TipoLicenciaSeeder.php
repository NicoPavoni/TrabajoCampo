<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoLicencia;

class TipoLicenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoLicencia::create([
            'nombre' => 'Copyright'
        ]);

        TipoLicencia::create([
            'nombre' => 'GPL'
        ]);

        TipoLicencia::create([
            'nombre' => 'Creative Commons'
        ]);
    }
}
