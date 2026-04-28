@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card" style="max-width: 650px;">
        
        <div class="auth-logo-container">
            <img src="{{ asset('images/petmatch_logo_modoclaro.png') }}" alt="PetMatch Logo" class="auth-logo">
        </div>

        <h2 class="auth-title">Únete a PetMatch</h2>
        <p class="auth-subtitle">Crea tu cuenta y encuentra la pareja ideal</p>

        @if ($errors->any())
            <div class="alert alert-danger" style="background-color: #f8d7da; border-color: #f5c2c7; color: #842029; border-radius: 12px; text-align: left; font-size: 0.9rem; margin-bottom: 2rem;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register" class="auth-form">
            @csrf
            
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">
                        <i class="fas fa-user"></i> Nombre Completo
                    </label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required placeholder="Ej: Juan Pérez">
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="juan@ejemplo.com">
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">
                        <i class="fas fa-phone"></i> Teléfono <span class="text-muted fw-normal" style="text-transform: none;">(opcional)</span>
                    </label>
                    <input type="tel" name="teléfono" class="form-control" value="{{ old('teléfono') }}" placeholder="600 000 000">
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">
                        <i class="fas fa-city"></i> Ciudad <span class="text-muted fw-normal" style="text-transform: none;">(opcional)</span>
                    </label>
                    <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad') }}" placeholder="Ej: Madrid">
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Contraseña
                    </label>
                    <input type="password" name="contraseña" class="form-control" required placeholder="********">
                </div>

                <div class="col-md-6 form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Confirmar Contraseña
                    </label>
                    <input type="password" name="contraseña_confirmation" class="form-control" required placeholder="********">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-w-full text-white mt-2">
                Crear Cuenta
            </button>
        </form>

        <div class="auth-link">
            ¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a>
        </div>
    </div>
</div>
@endsection