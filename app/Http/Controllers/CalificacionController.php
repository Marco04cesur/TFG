<?php
namespace App\Http\Controllers;
use App\Models\Calificacion;
use App\Models\Transaccion;
use Illuminate\Http\Request;

class CalificacionController extends Controller {
    public function create(Transaccion $transaccion) {
        return view('calificaciones.create', compact('transaccion'));
    }
    public function store(Request $request, Transaccion $transaccion) {
        $validated = $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);
        $matching = $transaccion->matching;
        $validated['usuario_id'] = auth()->id();
        Calificacion::create($validated);
        return redirect()->back()->with('success', 'Calificación enviada');
    }
}
