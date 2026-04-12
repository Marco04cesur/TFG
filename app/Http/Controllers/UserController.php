<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario; 
use App\Models\Perro;

class UserController extends Controller
{
    public function show($id)
    {
        // 1. Buscamos al usuario (dueño)
        $usuario = Usuario::findOrFail($id); 

        // 2. Buscamos todos los perros de este usuario que estén disponibles
        $perros = Perro::where('usuario_id', $usuario->id)
                       ->where('disponible', true)
                       ->get();

        return view('usuarios.show', compact('usuario', 'perros'));
    }
}