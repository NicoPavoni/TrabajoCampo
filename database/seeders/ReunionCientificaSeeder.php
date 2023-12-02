<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReunionCientifica;

class ReunionCientificaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReunionCientifica::create([
            'nombre' => '',
            'fecha_inicio' => '',
            'trabajo_id' => '',
            'pais' => 'Argentina',
            'nacional' => 0,
            'expositor_id' => '',
        ]);
    }
}
