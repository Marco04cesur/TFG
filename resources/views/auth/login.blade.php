@extends('layouts.app')

@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-logo-container">
            <img src="{{ asset('images/petmatch_logo_modoclaro.png') }}" alt="PetMatch Logo" class="auth-logo">
    </div>
    
    <h2 class="auth-title">Bienvenido a PetMatch</h2>
    <p class="auth-subtitle">Gestiona las citas de tus mascotas</p>
    
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