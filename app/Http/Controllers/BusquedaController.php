<?php
namespace App\Http\Controllers;
use App\Models\Perro;
class BusquedaController extends Controller {
    public function index() {
        return view('busqueda.index');
    }
    public function search(Request $request) {
        $query = Perro::where('disponible', 1)
            ->where('usuario_id', '!=', auth()->id());
        if ($request->raza) {
            $query->where('raza', 'like', '%' . $request->raza . '%');
        }
        if ($request->sexo) {
            $query->where('sexo', $request->sexo);
        }
        if ($request->edad_min) {
            $query->where('edad', '>=', $request->edad_min);
        }
        if ($request->edad_max) {
            $query->where('edad', '<=', $request->edad_max);
        }
        $perros = $query->paginate(10);
        return view('busqueda.resultados', compact('perros'));
    }
}
