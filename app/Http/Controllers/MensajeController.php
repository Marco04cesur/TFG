<?php
namespace App\Http\Controllers;
use App\Models\Matching;
use App\Models\Mensaje;
use App\Models\Perro;   
use Illuminate\Http\Request;

class MensajeController extends Controller {
    public function index(){
        // 1. Sacamos los IDs de todos los perros del usuario logueado
        $misPerrosIds = Perro::where('usuario_id', auth()->id())->pluck('id');
        
        // 2. Obtenemos solo los matches ACEPTADOS donde participe alguno de mis perros
        $matches = Matching::with(['perro1', 'perro2']) // Traemos los datos de los perros para que cargue más rápido
            ->where('estado', 'aceptado')
            ->where(function($query) use ($misPerrosIds) {
                $query->whereIn('perro_id_1', $misPerrosIds)
                      ->orWhereIn('perro_id_2', $misPerrosIds);
            })->get();

        // 3. Enviamos la variable a la vista 
        return view('mensajes.index', compact('matches'));
    }

    public function show(Matching $matching)
    {
        // 1. Verificamos quiénes son los perros de este match
        $misPerrosIds = auth()->user()->perros->pluck('id');

        // Si el usuario no es dueño de ninguno de los dos perros, lo echamos (por seguridad)
        if (!$misPerrosIds->contains($matching->perro_id_1) && !$misPerrosIds->contains($matching->perro_id_2)) {
            abort(403, 'No tienes permiso para ver este chat.');
        }

        // 2. Identificamos cuál es mi perro y cuál es el otro
        if ($misPerrosIds->contains($matching->perro_id_1)) {
            $miPerro = $matching->perro1;
            $otroPerro = $matching->perro2;
        } else {
            $miPerro = $matching->perro2;
            $otroPerro = $matching->perro1;
        }

        // 3. Cargamos los mensajes de este match
        $mensajes = $matching->mensajes()->orderBy('created_at', 'asc')->get();

        return view('mensajes.show', compact('matching', 'miPerro', 'otroPerro', 'mensajes'));
    }

    public function store(Request $request, Matching $matching)
    {
        $request->validate([
            'contenido' => 'required|string|max:1000',
            'mi_perro_id' => 'required|exists:perros,id'
        ]);

        // Guardamos el mensaje en la base de datos
        $matching->mensajes()->create([
            'perro_emisor_id' => $request->mi_perro_id, // Quién envía el mensaje
            'contenido' => $request->contenido
        ]);

        return back(); // Recargamos la página para ver el nuevo mensaje
    }
}
