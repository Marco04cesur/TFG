<?php
namespace App\Http\Controllers;
use App\Models\Transaccion;
use App\Models\Matching;
use Illuminate\Http\Request;
class TransaccionController extends Controller {
    public function create(Request $request, Matching $matching) {
        $validated = $request->validate([
            'fecha_acuerdo' => 'required|date',
            'terminos' => 'required|string',
            'costo' => 'nullable|numeric|min:0',
        ]);
        $validated['matching_id'] = $matching->id;
        $validated['estado'] = 'pendiente';
        Transaccion::create($validated);
        return redirect()->back()->with('success', 'Acuerdo propuesto');
    }
    public function accept(Transaccion $transaccion) {
        $transaccion->update(['estado' => 'aceptado']);
        return redirect()->back()->with('success', 'Acuerdo aceptado');
    }
}
