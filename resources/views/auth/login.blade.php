@extends('layouts.app')

@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-logo-container">
            <img src="{{ asset('images/petmatch_logo_modoclaro.png') }}" alt="PetMatch Logo" class="auth-logo">
    </div>
    
    <h2 class="auth-title">Bienvenido a PetMatch</h2>
    <p class="auth-subtitle">Gestiona las citas de tus mascotas</p>

    @if ($errors->has('email') || $errors->has('password') || session('error'))
            <div class="mb-4 p-3 d-flex align-items-center gap-3" style="background-color: #fff5f5; border: 1px solid #feb2b2; border-left: 5px solid var(--pure-red); border-radius: 0;">
                <i class="fas fa-exclamation-triangle" style="color: var(--pure-red);"></i>
                <span class="small fw-bold" style="color: #c53030; text-transform: uppercase; letter-spacing: 0.5px;">
                    El correo o la contraseña son incorrectos.
                </span>
            </div>
        @endif
    
    <form method="POST" action="{{ route('login') }}" class="auth-form">
      @csrf 

      <div class="form-group">
        <label class="form-label">
          <i class="fas fa-envelope"></i> Correo Electrónico
        </label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
      </div>
      
      <div class="form-group">
        <label class="form-label">
          <i class="fas fa-lock"></i> Contraseña
        </label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
      </div>
      
      <button type="submit" class="btn btn-primary btn-w-full text-white">
        Iniciar Sesión
      </button>
    </form>
    
    <div class="auth-link">
      ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
    </div>
  </div>
</div>
@endsection