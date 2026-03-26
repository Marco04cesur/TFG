<?php
namespace App\Http\Controllers;
use App\Models\Perro;
use App\Models\Matching;
class MatchingController extends Controller {
    public function show() {
        $userPerros = auth()->user()->perros->pluck('id')->toArray();
        $perro = Perro::where('disponible', 1)
            ->whereNotIn('id', $userPerros)
            ->first();
        return view('matching.show', compact('perro'));
    }
    public function like(Request $request, Perro $perro) {
        $userPerros = auth()->user()->perros;
        foreach ($userPerros as $myPerro) {
            Matching::create([
                'perro_id_1' => $myPerro->id,
                'perro_id_2' => $perro->id,
                'estado' => 'like',
            ]);
        }
        return redirect()->route('matching.show')->with('success', 'Me gusta registrado');
    }
    public function dislike(Perro $perro) {
        return redirect()->route('matching.show')->with('success', 'No me gusta registrado');
    }
}
