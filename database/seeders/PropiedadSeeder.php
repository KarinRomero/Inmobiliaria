<?php

namespace Database\Seeders;

use App\Models\Propiedad;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class PropiedadSeeder extends Seeder
{
    public function run(): void
    {
        Auth::login(Usuario::find(1));


        Propiedad::create([
            'nombre_titulo' => 'Casa 3 ambientes en Corrientes',
            'tipo' => 'casa',
            'direccion' => 'Junín 1234',
            'precio' => 85000.00,
            'descripcion' => 'Luminosa, con patio y parrilla. A 5 cuadras del centro.',
            'estado' => 'DISPONIBLE',
            'superficie_m2' => 120,
            'ambientes' => 3,
            'responsable_id' => 1, // El usuario Admin
        ]);

        Propiedad::create([
            'nombre_titulo' => 'Departamento céntrico 2 dormitorios',
            'tipo' => 'depto',
            'direccion' => '9 de Julio 567',
            'precio' => 65000.00,
            'descripcion' => 'Balcón al frente, cochera cubierta. Edificio con SUM.',
            'estado' => 'DISPONIBLE',
            'superficie_m2' => 75,
            'ambientes' => 3, // 2 dorm + living
            'responsable_id' => 1, // El usuario Admin
        ]);

        Propiedad::create([
            'nombre_titulo' => 'Terreno 10x30 en barrio residencial',
            'tipo' => 'terreno',
            'direccion' => 'Av. Armenia 2000',
            'precio' => 30000.00,
            'descripcion' => 'Todos los servicios. Ideal para construir.',
            'estado' => 'RESERVADA',
            'superficie_m2' => 300,
            'ambientes' => null, // Los terrenos no tienen ambientes
            'responsable_id' => 2, // El usuario Operario
        ]);
    }
}