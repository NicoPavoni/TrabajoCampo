<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Persona;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '1',
            'dni' => '10000001',
            'cuil' => '20100000011',
            'email' => 'persona1@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona1@example.com',
            'user_id' => 1,
        ]);

        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '2',
            'dni' => '10000002',
            'cuil' => '20100000021',
            'email' => 'persona2@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona2@example.com',
            'user_id' => 2,
        ]);

        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '3',
            'dni' => '10000003',
            'cuil' => '20100000031',
            'email' => 'persona3@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona3@example.com',
            'user_id' => 3,
        ]);

        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '4',
            'dni' => '10000004',
            'cuil' => '20100000041',
            'email' => 'persona4@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona4@example.com',
            'user_id' => 4,
        ]);

        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '5',
            'dni' => '10000005',
            'cuil' => '20100000051',
            'email' => 'persona5@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona5@example.com',
            'user_id' => 5,
        ]);

        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '6',
            'dni' => '10000006',
            'cuil' => '20100000061',
            'email' => 'persona6@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona6@example.com',
            'user_id' => 6,
        ]);

        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '7',
            'dni' => '10000007',
            'cuil' => '20100000071',
            'email' => 'persona7@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona7@example.com',
            'user_id' => 7,
        ]);

        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '8',
            'dni' => '10000008',
            'cuil' => '20100000081',
            'email' => 'persona8@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona8@example.com',
            'user_id' => 8,
        ]);

        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '9',
            'dni' => '10000009',
            'cuil' => '20100000091',
            'email' => 'persona9@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona9@example.com',
            'user_id' => 9,
        ]);

        Persona::create([
            'nombre' => 'Persona',
            'apellido' => '10',
            'dni' => '10000010',
            'cuil' => '20100000101',
            'email' => 'persona10@example.com',
            'telefono' => '221 1234567',
            'celular' => '221 1234567',
            'direccion_postal' => 'Calle Siempre Viva 742',
            'email_personal' => 'persona10@example.com',
            'user_id' => 10,
        ]);
    }
}
