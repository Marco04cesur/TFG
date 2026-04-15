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

                            <div class="accordion mb-4" id="accordionSeguridad">
                                <div class="accordion-item" style="border-radius: 15px; overflow: hidden; border: 1px solid #e0e6ed; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                                    <h2 class="accordion-header" id="headingSeguridad">
                                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeguridad" aria-expanded="false" aria-controls="collapseSeguridad" style="background-color: #f8f9fa; color: #333;">
                                            <i class="fas fa-shield-alt text-primary me-2"></i> Seguridad y Contraseña
                                        </button>
                                    </h2>
                                    <div id="collapseSeguridad" class="accordion-collapse collapse" aria-labelledby="headingSeguridad" data-bs-parent="#accordionSeguridad">
                                        <div class="accordion-body bg-white pt-4 pb-4">
                                            
                                            <p class="text-muted small mb-4"><i class="fas fa-info-circle me-1"></i> Si no deseas cambiar tu contraseña, deja estos campos en blanco.</p>

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small text-muted text-uppercase">Nueva Contraseña</label>
                                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mínimo 6 caracteres">
                                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small text-muted text-uppercase">Confirmar Contraseña</label>
                                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repite la nueva contraseña">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end mt-5 border-top pt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                    <i class="fas fa-save me-2"></i> Guardar Todo
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection