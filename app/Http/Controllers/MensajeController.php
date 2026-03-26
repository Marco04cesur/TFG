<?php
namespace App\Http\Controllers;
use App\Models\Matching;
use App\Models\Mensaje;
use Illuminate\Http\Request;
class MensajeController extends Controller {
    public function index() {
        $matchings = Matching::where(function ($query) {
            $query->where('usuario_id_1', auth()->id())
                ->orWhere('usuario_id_2', auth()->id());
        })->with('mensajes')->get();
        return view('mensajes.index', compact('matchings'));
    }
    public function show(Matching $matching) {
        return view('mensajes.show', compact('matching'));
    }
    public function store(Request $request, Matching $matching) {
        $validated = $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);
        $validated['matching_id'] = $matching->id;
        $validated['usuario_id'] = auth()->id();
        Mensaje::create($validated);
        return redirect()->back()->with('success', 'Mensaje enviado');
    }
}
