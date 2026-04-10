@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f7f6;
    }

    .profile-card {
        border-radius: 25px;
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        background: white;
        margin-top: 40px;
        margin-bottom: 50px;
    }

    /* Cabecera con degradado dentro de la tarjeta */
    .profile-cover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        height: 150px;
        border-radius: 25px 25px 0 0;
    }

    /* Contenedor del Avatar flotante */
    .avatar-wrapper {
        text-align: center;
        margin-top: -75px; /* Sube la foto hacia el degradado */
        position: relative;
        margin-bottom: 30px;
    }

    .avatar-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 6px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        object-fit: cover;
        background-color: #f8f9fa;
    }

    .form-label {
        font-weight: bold;
        color: #555;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .form-label i {
        color: #764ba2;
        margin-right: 5px;
        width: 20px;
        text-align: center;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        background-color: #f8f9fa;
        border: 2px solid #f8f9fa;
        transition: all 0.3s;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 50px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
        color: white;
    }

    /* Estilo Premium para el botón de Volver */
    .btn-back-custom {
        display: inline-flex;
        align-items: center;
        padding: 10px 22px;
        background-color: white;
        color: #764ba2;
        border-radius: 50px;
        font-weight: bold;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(118, 75, 162, 0.1);
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-back-custom i {
        transition: transform 0.3s ease;
    }

    .btn-back-custom:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(118, 75, 162, 0.25);
        transform: translateX(-5px); /* Mueve el botón ligeramente a la izquierda */
        border-color: transparent;
    }

    .btn-back-custom:hover i {
        transform: translateX(-3px); /* La flecha se mueve un poquito más para dar dinamismo */
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="mt-4 mb-3">
                <a href="{{ url('/dashboard') }}" class="btn-back-custom">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success rounded-4 mt-3 border-0 shadow-sm">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card profile-card">
                <div class="profile-cover"></div>

                <div class="card-body px-4 px-md-5 pb-5">
                    
                    <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="avatar-wrapper">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="avatar-preview mb-3" alt="Avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre) }}&background=764ba2&color=fff&size=150" class="avatar-preview mb-3" alt="Avatar Genérico">
                            @endif
                            
                            <div>
                                <label for="avatarInput" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                    <i class="fas fa-camera me-1"></i> Cambiar Foto
                                </label>
                                <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*">
                            </div>
                            @error('avatar') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="row g-4">
                            <h5 class="fw-bold mb-0 text-muted border-bottom pb-2">Información Personal</h5>
                            
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-user"></i> Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', auth()->user()->nombre) }}" required>
                                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-phone"></i> Teléfono</label>
                                <input type="tel" name="teléfono" class="form-control @error('teléfono') is-invalid @enderror" value="{{ old('teléfono', auth()->user()->teléfono) }}">
                                @error('teléfono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-map-marker-alt"></i> Ciudad</label>
                                <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror" value="{{ old('ciudad', auth()->user()->ciudad) }}">
                                @error('ciudad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <h5 class="fw-bold mb-0 text-muted border-bottom pb-2 mt-5">Seguridad</h5>

                            <div class="col-12">
                                <label class="form-label"><i class="fas fa-lock"></i> Nueva Contraseña <span class="text-muted text-lowercase fw-normal">(déjalo en blanco para mantener la actual)</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Solo si quieres cambiarla...">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                            <button type="submit" class="btn btn-save shadow-sm">
                                <i class="fas fa-save me-2"></i> Guardar Cambios
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection