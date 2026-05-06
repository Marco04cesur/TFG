@extends('layouts.app')

@section('content')

<!-- Estilo exclusivo para el hover de las tarjetitas de los perros -->
<style>
    .dog-mini-card-link {
        display: block;
        text-decoration: none;
        color: inherit;
        border-radius: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .dog-mini-card-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 129, 72, 0.15) !important;
    }
</style>

<!-- CABECERA DEL DUEÑO (Deep Forest con Logo y Botones) -->
<div class="page-header" style="background-color: var(--deep-forest); padding: 3rem 0 7rem 0; text-align: left;">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- Izquierda: Logo y Textos -->
            <div class="col-lg-6 d-flex align-items-center gap-4">
                <div class="shadow-sm d-none d-sm-block" style="background-color: white; padding: 12px; border-radius: 18px;">
                    <img src="{{ asset('images/petmatch_logo_modoclaro.png') }}" alt="PetMatch Logo" style="height: 60px; width: auto; display: block;">
                </div>
                
                <div>
                    <h1 class="mb-1" style="font-weight: 800; color: white; letter-spacing: -1px;">Perfil del Dueño</h1>
                    <p class="mb-0 fs-5" style="color: rgba(255, 255, 255, 0.85); font-weight: 500;">Conoce más sobre {{ $usuario->nombre }}</p>
                </div>
            </div>
            
            <!-- Derecha: Botonera (Volver y Dashboard) -->
            <div class="col-lg-6 mt-4 mt-lg-0 d-flex gap-2 justify-content-lg-end flex-wrap">
                
                <a href="{{ url()->previous() }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-bold d-flex align-items-center" style="border-width: 2px;">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>

                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-bold d-flex align-items-center" style="border-width: 2px; background-color: rgba(255,255,255,0.1);">
                    <i class="fas fa-home me-2"></i> Inicio
                </a>
                
            </div>
            
        </div>
    </div>
</div>

<!-- CONTENEDOR PRINCIPAL -->
<div class="container mb-5" style="margin-top: -4rem; position: relative; z-index: 10;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- TARJETA DEL USUARIO -->
            <div class="stat-card p-4 p-md-5 text-center border-0 shadow-lg mb-5" style="border-radius: 24px;">
                
                <!-- Avatar Flotante -->
                <div class="position-relative d-inline-block mb-4" style="margin-top: -85px;">
                    @if($usuario->avatar)
                        <img src="{{ asset('storage/' . $usuario->avatar) }}" class="rounded-circle object-fit-cover shadow-lg" style="width: 140px; height: 140px; border: 6px solid white;" alt="Avatar de {{ $usuario->nombre }}">
                    @else
                        <!-- Fondo verde Deep Forest para avatares genéricos -->
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nombre) }}&background=034732&color=fff&size=150&bold=true" class="rounded-circle shadow-lg" style="width: 140px; height: 140px; border: 6px solid white;" alt="Avatar Genérico">
                    @endif
                </div>
                
                <h2 class="fw-bold mb-2" style="color: var(--deep-forest); letter-spacing: -1px; font-size: 2.2rem;">{{ $usuario->nombre }}</h2>
                
                <p class="fs-5 text-muted mb-4">
                    <i class="fas fa-map-marker-alt me-2" style="color: var(--pure-red);"></i> {{ $usuario->ciudad ?? 'Ciudad no especificada' }}
                </p>
                
                <!-- Insignia de Miembro -->
                <div class="d-inline-flex align-items-center rounded-pill px-4 py-2 fw-bold small" style="background-color: rgba(0, 129, 72, 0.05); color: var(--sea-green); border: 1px solid rgba(0, 129, 72, 0.1);">
                    <i class="fas fa-paw me-2" style="color: var(--tiger-orange);"></i> Miembro de PetMatch
                </div>
            </div>

            <!-- TÍTULO: SUS PERROS -->
            <div class="d-flex justify-content-between align-items-end mb-4 mt-5 border-bottom pb-3" style="border-color: rgba(0, 129, 72, 0.1) !important;">
                <h4 class="fw-bold mb-0" style="color: var(--deep-forest);">Los peludos de {{ $usuario->nombre }}</h4>
            </div>

            <!-- CUADRÍCULA DE SUS PERROS -->
            <div class="row g-4">
                @forelse($perros as $perro)
                    <div class="col-md-6">
                        <a href="{{ route('perros.show', $perro) }}" class="dog-mini-card-link stat-card h-100 border-0 overflow-hidden shadow-sm">
                            
                            <!-- Foto del Perro -->
                            <div style="height: 220px; background-color: var(--bg-secondary); position: relative;">
                                @if($perro->foto_url)
                                    <img src="{{ asset('storage/' . $perro->foto_url) }}" class="w-100 h-100 object-fit-cover" alt="{{ $perro->nombre }}">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-dog fa-4x" style="color: var(--camel); opacity: 0.5;"></i>
                                    </div>
                                @endif
                                
                                <!-- Icono de sexo superpuesto -->
                                <div class="position-absolute bottom-0 end-0 m-3 d-flex align-items-center justify-content-center rounded-circle shadow-sm" 
                                     style="background-color: white; width: 35px; height: 35px;">
                                    <i class="fas fa-{{ $perro->sexo == 'M' ? 'mars' : 'venus' }}" style="color: {{ $perro->sexo == 'M' ? 'var(--deep-forest)' : 'var(--tiger-orange)' }}; font-size: 1.1rem;"></i>
                                </div>
                            </div>
                            
                            <!-- Info del Perro -->
                            <div class="p-4 text-center">
                                <h4 class="fw-bold mb-1" style="color: var(--deep-forest); letter-spacing: -0.5px;">
                                    {{ $perro->nombre }} 
                                </h4>
                                <p class="small text-uppercase fw-bold mb-0" style="color: var(--sea-green); letter-spacing: 1px;">
                                    {{ $perro->raza }} <span class="text-muted mx-1">&bull;</span> {{ $perro->edad }} años
                                </p>
                            </div>

                        </a>
                    </div>
                @empty
                    <!-- ESTADO VACÍO -->
                    <div class="col-12 text-center py-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px; background-color: var(--bg-secondary);">
                            <i class="fas fa-search fa-2x" style="color: var(--sea-green); opacity: 0.5;"></i>
                        </div>
                        <h5 class="fw-bold text-muted mb-0">No hay perros registrados</h5>
                        <p class="text-muted small mt-2">Parece que este usuario aún no ha añadido mascotas.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection