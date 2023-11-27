<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Persona 1',
            'email' => 'persona1@example.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Persona 2',
            'email' => 'persona2@example.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Persona 3',
            'email' => 'persona3@example.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Persona 4',
            'email' => 'persona4@example.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Persona 5',
            'email' => 'persona5@example.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Persona 6',
            'email' => 'persona6@example.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Persona 7',
            'email' => 'persona7@example.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Persona 8',
            'email' => 'persona8@example.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Persona 9',
            'email' => 'persona9@example.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Persona 10',
            'email' => 'persona10@example.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
