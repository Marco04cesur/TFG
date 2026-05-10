<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Para crear perros en los usuarios que ya existenS
    $usuarios = Usuario::all();

    foreach ($usuarios as $usuario) {
        // Creamos entre 1 y 2 perros para cada usuario
        \App\Models\Perro::factory()->count(rand(1, 2))->create([
            'usuario_id' => $usuario->id
        ]);
    }
    }
    
}
