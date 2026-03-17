<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    
    // Mostrar formulario de login
    public function showLogin() {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request) {
    // 1. Validar datos
    $credentials = $request->validate([
        'email' => 'required|email',
        'contraseña' => 'required|min:6',
    ]);

    // 2. BUSCAR AL USUARIO (¡Esta es la línea que te falta!)
    $usuario = \App\Models\Usuario::where('email', $credentials['email'])->first();

    // 3. Verificar si existe y si la contraseña coincide
    if (!$usuario || !\Illuminate\Support\Facades\Hash::check($credentials['contraseña'], $usuario->contraseña)) {
        return back()->withErrors(['email' => 'Credenciales inválidas']);
    }

    // 4. Autenticar oficialmente
    \Illuminate\Support\Facades\Auth::login($usuario);

    // 5. Redirigir
    return redirect()->intended('/dashboard');
}

    // Mostrar formulario de registro
    public function showRegister() {
        return view('auth.register');
    }

    // Procesar registro
    public function register(Request $request) {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios',
            'contraseña' => 'required|min:6|confirmed',
            'teléfono' => 'nullable|max:20',
            'ciudad' => 'nullable|max:100',
        ]);

        $usuario = Usuario::create($data);
        session(['usuario_id' => $usuario->id, 'usuario' => $usuario]);
        
        return redirect('/dashboard')->with('success', 'Registro exitoso');
    }

    // Dashboard
    public function dashboard() {
        if (!session('usuario_id')) {
            return redirect('/login');
        }
        return view('dashboard.index');
    }

    // Logout
    public function logout() {
        session()->forget(['usuario_id', 'usuario']);
        return redirect('/login');
    }
}
