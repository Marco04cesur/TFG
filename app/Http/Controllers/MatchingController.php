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
        // 3. Que yo no haya interactuado con ellos todavía
        $perro = Perro::whereNotIn('usuario_id', [auth()->id()])
        ->whereDoesntHave('matchingsRecibidos', function($q) use ($misPerrosIds) {
            $q->whereIn('perro_id_1', $misPerrosIds);
        })
        ->first();

        return view('matching.show', compact('perro'));
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

    public function store(Request $request)
        {
            // 1. Validamos que lleguen los IDs correctos
            $request->validate([
                'perro_id_1' => 'required|exists:perros,id',
                'perro_id_2' => 'required|exists:perros,id',
            ]);

            // 2. Comprobamos si YA EXISTE un match entre estos dos perros (para no duplicar)
            $existeMatch = Matching::where(function($query) use ($request) {
                $query->where('perro_id_1', $request->perro_id_1)
                    ->where('perro_id_2', $request->perro_id_2);
            })->orWhere(function($query) use ($request) {
                $query->where('perro_id_1', $request->perro_id_2)
                    ->where('perro_id_2', $request->perro_id_1);
            })->first();

            if ($existeMatch) {
                return back()->with('error', 'Ya existe una solicitud de match entre estos perritos. ¡Ve a Mis Matches para ver el estado!');
            }

            // 3. Creamos el Match en la base de datos
            Matching::create([
                'perro_id_1' => $request->perro_id_1,
                'perro_id_2' => $request->perro_id_2,
                'estado' => 'pendiente' // Puede ser pendiente, aceptado o rechazado
            ]);

            return back()->with('success', '¡Solicitud de match enviada! Ahora toca cruzar los dedos 🐾');
        }

        // Muestra la lista de matches
    public function listado()
    {
        // Sacamos los IDs de todos los perros del usuario logueado
        $misPerrosIds = Perro::where('usuario_id', auth()->id())->pluck('id');

        // 1. Solicitudes RECIBIDAS (Alguien dio like a mi perro)
        $recibidas = Matching::with(['perro1', 'perro2'])
            ->whereIn('perro_id_2', $misPerrosIds)
            ->where('estado', 'pendiente')
            ->get();

        // 2. Solicitudes ENVIADAS (Mi perro dio like a otro)
        $enviadas = Matching::with(['perro1', 'perro2'])
            ->whereIn('perro_id_1', $misPerrosIds)
            ->where('estado', 'pendiente')
            ->get();

        // 3. Matches ACEPTADOS (Por ambas partes)
        $aceptados = Matching::with(['perro1', 'perro2'])
            ->where(function($query) use ($misPerrosIds) {
                $query->whereIn('perro_id_1', $misPerrosIds)
                      ->orWhereIn('perro_id_2', $misPerrosIds);
            })
            ->where('estado', 'aceptado')
            ->get();

        return view('matching.listado', compact('recibidas', 'enviadas', 'aceptados', 'misPerrosIds'));
    }

    // Aceptar un match
    public function aceptar(Matching $matching)
    {
        $matching->estado = 'aceptado';
        $matching->save();
        return back()->with('success', '¡Match aceptado! Ahora podéis empezar a chatear.');
    }

    // Rechazar un match
    public function rechazar(Matching $matching)
    {
        $matching->estado = 'rechazado';
        $matching->save();
        return back()->with('success', 'Solicitud rechazada correctamente.');
    }
}