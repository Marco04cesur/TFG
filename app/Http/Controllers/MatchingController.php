<?php
namespace App\Http\Controllers;

use App\Models\Perro;
use App\Models\Matching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchingController extends Controller {

    public function show() {
        $usuario = Auth::user();
        $misPerrosIds = $usuario->perros->pluck('id')->toArray();

        // Buscamos perros que:
        // 1. No sean míos
        // 2. Estén disponibles
        // 3. Que yo no haya interactuado con ellos todavía (opcional pero recomendado)
        $perro = Perro::whereNotIn('usuario_id', [auth()->id()])
        ->whereDoesntHave('matchingsRecibidos', function($q) use ($misPerrosIds) {
            $q->whereIn('perro_id_1', $misPerrosIds);
        })
        ->first();

        return view('matching.show', compact('perro'));
    }

    public function like(Request $request, Perro $perro) {
        // Suponiendo que el usuario navega con su primer perro o uno seleccionado
        $miPerro = Auth::user()->perros()->first(); 

        if (!$miPerro) {
            return redirect()->back()->with('error', 'Debes registrar un perro primero');
        }

        // 1. Crear el Like
        Matching::create([
            'perro_id_1' => $miPerro->id,
            'perro_id_2' => $perro->id,
            'estado' => 'aceptado',
        ]);

        // 2. Comprobar si hay reciprocidad (MATCH)
        $hayReciprocidad = Matching::where('perro_id_1', $perro->id)
            ->where('perro_id_2' , $miPerro->id)
            ->where('estado', 'aceptado')
            ->exists();

        if ($hayReciprocidad) {
            // Aquí podrías marcar ambos registros como 'match' o enviar una notificación
            return redirect()->route('matching.show')->with('match', '¡Es un Match! Ya puedes hablar con el dueño de ' . $perro->nombre);
        }

        return redirect()->route('matching.show');
    }

    public function dislike(Perro $perro) {
        $miPerro = Auth::user()->perros()->first();
        if (!$miPerro) {
        return redirect()->back()->with('error', 'Necesitas tener un perro para usar el matching.');
    }

        Matching::create([
            'perro_id_1' => $miPerro->id,
            'perro_id_2' => $perro->id,
            'estado' => 'rechazado',
        ]);

        return redirect()->route('matching.show');
    }

    public function misMatches() {
    $usuario = auth()->user();
    $misPerrosIds = $usuario->perros->pluck('id')->toArray();

    // El 'with' es la clave para que no salga el error de "null"
    $matches = \App\Models\Matching::with(['perro1', 'perro2'])
        ->where(function($query) use ($misPerrosIds) {
            $query->whereIn('perro_id_1', $misPerrosIds)
                  ->orWhereIn('perro_id_2', $misPerrosIds);
        })
        ->where('estado', 'aceptado')
        ->get();

    return view('matching.listado', compact('matches', 'misPerrosIds'));
}
}