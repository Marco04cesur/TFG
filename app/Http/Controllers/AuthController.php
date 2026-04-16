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
        'password' => 'required|min:6',
    ]);

    // 2. BUSCAR AL USUARIO POR EMAIL
    $usuario = \App\Models\Usuario::where('email', $credentials['email'])->first();

    // 3. Verificar si existe y si la contraseña coincide
    if (!$usuario || !\Illuminate\Support\Facades\Hash::check($credentials['password'], $usuario->contraseña)) {
        return back()->withErrors(['email' => 'Credenciales inválidas']);
    }

    // 4. Autenticar oficialmente
    \Illuminate\Support\Facades\Auth::login($usuario);
    Auth::login($usuario);

    session(['usuario_id' => $usuario->id, 'usuario' => $usuario]);

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
            'password' => 'required|min:6|confirmed',
            'teléfono' => 'nullable|max:20',
            'ciudad' => 'nullable|max:100',
        ]);

        $usuario = Usuario::create($data);
        session(['usuario_id' => $usuario->id, 'usuario' => $usuario]);
        
        return redirect('/dashboard')->with('success', 'Registro exitoso');
    }

    // Dashboard
    public function dashboard() {
    if (!Auth::check()) {  // en lugar de session('usuario_id')
        return redirect('/login');
    }
    // Asegura que la sesión manual también esté
    if (!session('usuario')) {
        session(['usuario' => Auth::user()]);
    }
    return view('dashboard.index');
}

    // Logout
    public function logout() {
        session()->forget(['usuario_id', 'usuario']);
        return redirect('/login');
    }

public function editPerfil()
{
    // Obtenemos el usuario autenticado
    $usuario = auth()->user();
    
    // Retornamos la vista 
    return view('auth.perfil', compact('usuario'));
}

public function updatePerfil(Request $request)
{
    $usuario = auth()->user();

    // Validamos los datos
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
        'avatar' => 'nullable|image|max:2048',
        'password' => 'nullable|min:6|confirmed'
    ], [
         // Mensajes de error personalizados
        'password.confirmed' => 'Las contraseñas no coinciden.',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres.'
    ]);

    // Subimos la foto si el usuario seleccionó una
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $usuario->avatar = $path;
    }

    // Actualizamos el resto de datos
    $usuario->nombre = $request->nombre;
    $usuario->email = $request->email;
    $usuario->teléfono = $request->teléfono;
    $usuario->ciudad = $request->ciudad;
    $usuario->save();

    // Si ha escrito una contraseña nueva, la encriptamos y la guardamos
    if ($request->filled('password')) {
            \App\Models\Usuario::where('id', $usuario->id)->update([
                'contraseña' => bcrypt($request->password)
            ]);
        }

        return back()->with('success', '¡Perfil actualizado correctamente!');
    }
}
