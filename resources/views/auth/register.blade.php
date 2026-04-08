@extends('layouts.app')

@section('content')
<style>
    <style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 40px 15px;
        /* Animación suave al entrar a la página */
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        border-radius: 25px; /* Bordes un poco más suaves */
        border: none;
        /* Sombra mucho más marcada para el efecto de "salto" */
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
        background-color: #ffffff;
        transition: transform 0.3s ease;
    }

    /* Efecto extra: la tarjeta reacciona si pasas el ratón */
    .card:hover {
        transform: translateY(-5px);
    }

    .dog-icon {
        width: 85px;
        height: 85px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -75px auto 20px;
        /* Sombra del icono para que también flote */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        color: #764ba2;
        border: 5px solid #ffffff;
    }

    /* Resto de estilos de inputs y botones igual... */

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 40px 15px;
    }
    .card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    .dog-icon {
        width: 80px;
        height: 80px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -70px auto 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        color: #764ba2;
        border: 4px solid white;
    }
    .form-control {
        border-radius: 10px;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border: 2px solid #f8f9fa;
    }
    .form-control:focus {
        background-color: #fff;
        border-color: #e0e6ed;
        box-shadow: none;
    }
    .btn-primary {
        background: #764ba2;
        border: none;
        padding: 12px;
        font-weight: bold;
        border-radius: 50px;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background: #5a397a;
        transform: translateY(-2px);
    }
    .error-list {
        color: #dc3545;
        background: #f8d7da;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.9em;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7">
            <div class="card mt-5">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="dog-icon">
                        <i class="fas fa-dog fa-2x"></i>
                    </div>

                    <h2 class="text-center fw-bold mb-1" style="color: #333;">PetMatch</h2>
                    <p class="text-center text-muted mb-4">Crea tu cuenta para empezar</p>

                    @if ($errors->any())
                        <div class="error-list">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/register">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required placeholder="Ej: Juan Pérez">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="juan@ejemplo.com">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Teléfono (opcional)</label>
                                <input type="tel" name="teléfono" class="form-control" value="{{ old('teléfono') }}" placeholder="600 000 000">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Ciudad (opcional)</label>
                                <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad') }}" placeholder="Ej: Madrid">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Contraseña</label>
                                <input type="password" name="contraseña" class="form-control" required placeholder="********">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Confirmar Contraseña</label>
                                <input type="password" name="contraseña_confirmation" class="form-control" required placeholder="********">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary shadow-sm text-uppercase">Crear Cuenta</button>
                        </div>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="small text-muted mb-0">¿Ya tienes cuenta? 
                            <a href="/login" class="text-decoration-none text-primary fw-bold">Inicia sesión aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection