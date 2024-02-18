<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(TrabajoPublicadoSeeder::class);
        $this->call(TipoDocumentoTecnicoSeeder::class);
        $this->call(InstitucionSeeder::class);
        $this->call(ArticuloConReferatoSeeder::class);
        $this->call(DocumentoTecnicoSeeder::class);
        $this->call(EventoSeeder::class);
        $this->call(LibroCapituloSeeder::class);
        $this->call(PatenteSeeder::class);
        $this->call(RevistaNacionalSeeder::class);
        $this->call(TipoLicenciaSeeder::class);
    }
}
