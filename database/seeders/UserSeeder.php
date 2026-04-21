<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nombre' => 'Admin Inmobiliaria', // Cambié name por nombre
            'email' => 'admin@inmobiliaria.com',
            'password' => Hash::make('password'),
            'rol' => 'ADMINISTRADOR', // Le damos rol de admin
        ]);

        Usuario::create([
            'nombre' => 'Usuario Prueba', // Cambié name por nombre
            'email' => 'test@test.com', 
            'password' => Hash::make('password'),
            'rol' => 'OPERARIO', // Este queda como operario
        ]);
    }
}