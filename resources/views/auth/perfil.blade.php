@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="mb-4">
                <a href="{{ url('/dashboard') }}" class="text-decoration-none fw-bold" style="color: var(--sea-green); transition: color 0.3s;">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="alert shadow-sm border-0 mb-4" style="background-color: var(--bg-secondary); color: var(--deep-forest); border-radius: 15px;">
                    <i class="fas fa-check-circle me-2" style="color: var(--sea-green);"></i> {{ session('success') }}
                </div>
            @endif

            <div class="stat-card p-4 p-md-5 border-0">
                
                <h2 class="mb-5 fw-bold" style="color: var(--deep-forest); letter-spacing: -1px;">Editar Perfil</h2>

                <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                    
                    <div class="d-flex align-items-center flex-wrap gap-4 mb-5 pb-4 border-bottom" style="border-color: rgba(0, 129, 72, 0.1) !important;">
                        <div class="position-relative">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 110px; height: 110px;" alt="Avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre) }}&background=034732&color=fff&size=150&bold=true" class="rounded-circle shadow-sm" style="width: 110px; height: 110px;" alt="Avatar Genérico">
                            @endif
                        </div>
                        
                        <div>
                            <label for="avatarInput" class="btn rounded-pill px-4 fw-bold" style="border-color: var(--sea-green); color: var(--deep-forest); cursor: pointer;">
                                <i class="fas fa-camera me-2"></i> Cambiar Foto
                            </label>
                            <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*">
                            <p class="text-muted small mt-2 mb-0">Recomendado: Imagen cuadrada (JPG o PNG).</p>
                            @error('avatar') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control p-3 @error('nombre') is-invalid @enderror" value="{{ old('nombre', auth()->user()->nombre) }}" required style="border-radius: 12px;">
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control p-3 @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required style="border-radius: 12px;">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;">Teléfono</label>
                            <input type="tel" name="teléfono" class="form-control p-3 @error('teléfono') is-invalid @enderror" value="{{ old('teléfono', auth()->user()->teléfono) }}" style="border-radius: 12px;">
                            @error('teléfono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control p-3 @error('ciudad') is-invalid @enderror" value="{{ old('ciudad', auth()->user()->ciudad) }}" style="border-radius: 12px;">
                            @error('ciudad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="accordion mb-5" id="accordionSeguridad">
                        <div class="accordion-item" style="border-radius: 15px; overflow: hidden; border: 1px solid rgba(0, 129, 72, 0.15); box-shadow: none;">
                            <h2 class="accordion-header" id="headingSeguridad">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeguridad" aria-expanded="false" aria-controls="collapseSeguridad" style="background-color: var(--bg-secondary); color: var(--deep-forest);">
                                    <i class="fas fa-shield-alt me-2" style="color: var(--tiger-orange);"></i> Seguridad y Contraseña
                                </button>
                            </h2>
                            <div id="collapseSeguridad" class="accordion-collapse collapse" aria-labelledby="headingSeguridad" data-bs-parent="#accordionSeguridad">
                                <div class="accordion-body bg-white pt-4 pb-4">
                                    
                                    <p class="text-muted small mb-4"><i class="fas fa-info-circle me-1" style="color: var(--sea-green);"></i> Si no deseas cambiar tu contraseña, deja estos campos en blanco.</p>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Nueva Contraseña</label>
                                            <input type="password" name="password" class="form-control p-3 @error('password') is-invalid @enderror" placeholder="Mínimo 6 caracteres" style="border-radius: 12px;">
                                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Confirmar Contraseña</label>
                                            <input type="password" name="password_confirmation" class="form-control p-3" placeholder="Repite la nueva contraseña" style="border-radius: 12px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4" style="border-color: rgba(0, 129, 72, 0.1) !important;">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm w-100">
                            <i class="fas fa-save me-2"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection