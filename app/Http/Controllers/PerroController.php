<?php
namespace App\Http\Controllers;
use App\Models\Perro;
use Illuminate\Http\Request;
class PerroController extends Controller {
    public function index() {
        $perros = auth()->user()->perros;
        return view('perros.index', compact('perros'));
    }
    public function create() {
        return view('perros.create');
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'sexo' => 'required|in:macho,hembra',
            'edad' => 'required|integer|min:0',
            'peso' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);
        $validated['usuario_id'] = auth()->id();
        $validated['disponible'] = 1;
        Perro::create($validated);
        return redirect()->route('perros.index')->with('success', 'Perro creado');
    }
    public function show(Perro $perro) {
        return view('perros.show', compact('perro'));
    }
    public function edit(Perro $perro) {
        $this->authorize('update', $perro);
        return view('perros.edit', compact('perro'));
    }
    public function update(Request $request, Perro $perro) {
        $this->authorize('update', $perro);
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'sexo' => 'required|in:macho,hembra',
            'edad' => 'required|integer|min:0',
            'peso' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);
        $perro->update($validated);
        return redirect()->route('perros.show', $perro)->with('success', 'Perro actualizado');
    }
    public function destroy(Perro $perro) {
        $this->authorize('delete', $perro);
        $perro->delete();
        return redirect()->route('perros.index')->with('success', 'Perro eliminado');
    }
}
