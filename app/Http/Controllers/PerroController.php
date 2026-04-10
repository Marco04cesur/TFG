<?php

namespace App\Http\Controllers;

use App\Models\Perro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importante para las fotos

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
            'sexo' => 'required|in:M,H', // Ajustado a tu migración
            'edad' => 'required|integer|min:0',
            'peso' => 'required|numeric|min:0',
            'descripción' => 'nullable|string',
            'foto_url' => 'nullable|image|max:2048', // Validación de imagen
        ]);

        // Manejo de la foto
        if ($request->hasFile('foto_url')) {
            $path = $request->file('foto_url')->store('perros', 'public');
            $validated['foto_url'] = $path;
        }

        $validated['usuario_id'] = auth()->id();
        $validated['disponible'] = 1;

        Perro::create($validated);

        return redirect()->route('perros.index')->with('success', 'Perro creado con éxito');
    }

    public function show(Perro $perro) {
        return view('perros.show', compact('perro'));
    }

    public function edit(Perro $perro) {
    // Si el ID del usuario logueado NO es el del dueño del perro...
    if (auth()->id() !== $perro->usuario_id) {
        abort(403, 'No tienes permiso para editar este perro.');
    }

    return view('perros.edit', compact('perro'));
}

    // El resto de métodos (edit, update, destroy) siguen la misma lógica
    public function update(Request $request, Perro $perro) {
    // 1. Validar que el usuario sea el dueño (ahora que quitamos el authorize)
    if (auth()->id() !== $perro->usuario_id) {
        abort(403);
    }

    // 2. Validar los datos (Asegúrate de que 'descripción' tenga tilde si así está en la DB)
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'raza' => 'required|string|max:255',
        'sexo' => 'required|in:M,H',
        'edad' => 'required|integer|min:0',
        'peso' => 'required|numeric|min:0',
        'descripción' => 'nullable|string', // <--- Revisa la tilde aquí
        'foto' => 'nullable|image|max:2048',
    ]);

    // 3. Gestionar la foto si se sube una nueva
    if ($request->hasFile('foto')) {
        // Borramos la vieja para no acumular basura
        if ($perro->foto_url) {
            \Storage::disk('public')->delete($perro->foto_url);
        }
        $path = $request->file('foto')->store('perros', 'public');
        $validated['foto_url'] = $path;
    }

    // 4. EL PASO CRUCIAL: Actualizar
    // Si usas $perro->update($validated), asegúrate de que 'descripción'
    // esté en el array $fillable de tu modelo Perro.php
    $perro->update($validated);

    return redirect()->route('perros.index')->with('success', 'Perro actualizado correctamente');
}

    public function destroy(Perro $perro) {
    // Validamos que el usuario logueado sea el dueño
    if (auth()->id() !== $perro->usuario_id) {
        abort(403, 'No tienes permiso para eliminar este perro.');
    }

    // Opcional: Borrar la foto del servidor si existe
    if ($perro->foto_url) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($perro->foto_url);
    }

    $perro->delete();
    return redirect()->route('perros.index')->with('success', 'Perro eliminado correctamente');
}
}