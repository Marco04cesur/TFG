<?php
namespace App\Http\Controllers;
use App\Models\Matching;
use App\Models\Mensaje;
use Illuminate\Http\Request;
class MensajeController extends Controller {
    public function index() {
    $usuario = auth()->user();
    
    // 1. Obtenemos los IDs de TODOS los perros que me pertenecen
    $misPerrosIds = $usuario->perros->pluck('id')->toArray();

    // 2. Buscamos los matches donde alguno de MIS perros sea participante
    // Y usamos los nombres de columna correctos de tu DB: perro_id_1 y perro_id_2
    $matchings = Matching::where(function($query) use ($misPerrosIds) {
            $query->whereIn('perro_id_1', $misPerrosIds)
                  ->orWhereIn('perro_id_2', $misPerrosIds);
        })
        ->where('estado', 'aceptado') // Solo los que son match real
        ->with(['perro1', 'perro2']) // Cargar datos de los perros para la vista
        ->get();

    return view('mensajes.index', compact('matchings', 'misPerrosIds'));
}
    public function show(Matching $matching) {
    // Seguridad: Verificar que el usuario pertenece a este match
    $misPerrosIds = auth()->user()->perros->pluck('id')->toArray();
    if (!in_array($matching->perro_id_1, $misPerrosIds) && !in_array($matching->perro_id_2, $misPerrosIds)) {
        abort(403);
    }

    $mensajes = $matching->mensajes()->orderBy('created_at', 'asc')->get();
    $mensajes = $matching->mensajes()->with('perroEmisor')->orderBy('created_at', 'asc')->get();
    return view('mensajes.show', compact('matching', 'mensajes'));
}
    public function store(Request $request, Matching $matching) {
    $validated = $request->validate([
        'contenido' => 'required|string|max:1000',
    ]);

    // Buscamos cuál de tus perros pertenece a este match
    $miPerro = auth()->user()->perros()
        ->where(function($query) use ($matching) {
            $query->where('id', $matching->perro_id_1)
                  ->orWhere('id', $matching->perro_id_2);
        })->first();

    if (!$miPerro) {
        abort(403, 'No tienes permiso para enviar mensajes en este match.');
    }

    // Guardamos el mensaje con el campo correcto: perro_emisor_id
    \App\Models\Mensaje::create([
        'matching_id' => $matching->id,
        'perro_emisor_id' => $miPerro->id, // <--- ESTO ES LO QUE FALTABA
        'contenido' => $validated['contenido'],
    ]);

    return redirect()->back()->with('success', 'Mensaje enviado');
}
}
