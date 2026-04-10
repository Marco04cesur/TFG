<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perro; // Asegúrate de importar el modelo Perro

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Empezamos la búsqueda: Solo perros disponibles 
        // y que NO sean los del propio usuario logueado.
        $query = Perro::where('disponible', true)
                      ->where('usuario_id', '!=', auth()->id()); 
                      // Ojo: si tu columna de dueño se llama 'user_id', cámbialo arriba.

        // 2. Filtro por Raza (si el usuario escribió algo)
        if ($request->filled('raza')) {
            $query->where('raza', 'like', '%' . $request->raza . '%');
        }

        // 3. Filtro por Sexo (si seleccionó M o H)
        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
        }

        // 4. Filtro por Ciudad (como la ciudad está en el dueño, usamos whereHas)
        if ($request->filled('ciudad')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('ciudad', 'like', '%' . $request->ciudad . '%');
            });
        }

        // 5. Obtenemos los resultados paginados (de 9 en 9 para que cuadre la rejilla)
        $perros = $query->paginate(9);

        // 6. Enviamos la variable $perros a la vista
        return view('busqueda.index', compact('perros'));
    }
}