<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerroController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\Controller;


// Rutas públicas (sin autenticar)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas (requieren autenticar)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/matches', [MatchingController::class, 'misMatches'])->name('matching.listado');
});

// Ruta inicial
Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('perros', PerroController::class);
    Route::get('/perfil/editar', [App\Http\Controllers\AuthController::class, 'editPerfil'])->name('perfil.edit');
    
});

Route::get('/buscar', [BusquedaController::class, 'index'])->name('busqueda.index');
Route::get('/buscar/resultados', [BusquedaController::class, 'search'])->name('busqueda.search');

Route::get('/matching', [MatchingController::class, 'show'])->name('matching.show');
Route::post('/matching/{perro}/like', [MatchingController::class, 'like'])->name('matching.like');
Route::post('/matching/{perro}/dislike', [MatchingController::class, 'dislike'])->name('matching.dislike');

Route::get('/mensajes', [MensajeController::class, 'index'])->name('mensajes.index');
Route::get('/mensajes/{matching}', [MensajeController::class, 'show'])->name('mensajes.show');
Route::post('/mensajes/{matching}', [MensajeController::class, 'store'])->name('mensajes.store');

Route::post('/transacciones/crear', [TransaccionController::class, 'create'])->name('transacciones.create');
Route::post('/transacciones/{transaccion}/aceptar', [TransaccionController::class, 'accept'])->name('transacciones.accept');

Route::get('/transacciones/{transaccion}/calificar', [CalificacionController::class, 'create'])->name('calificaciones.create');
Route::post('/transacciones/{transaccion}/calificar', [CalificacionController::class, 'store'])->name('calificaciones.store');

Route::get('/mis-matches', [MatchingController::class, 'misMatches'])->name('matching.listado');

Route::put('/perfil', [AuthController::class, 'updatePerfil'])->name('perfil.update');