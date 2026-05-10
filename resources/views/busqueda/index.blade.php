@extends('layouts.app')

@section('content')

<!-- Estilos para efectos hover en las tarjetas de búsqueda -->
<style>
    .explore-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .explore-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 129, 72, 0.12) !important;
    }
    .btn-ver-perfil {
        background-color: rgba(0, 129, 72, 0.1);
        color: var(--sea-green);
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    .btn-ver-perfil:hover {
        background-color: var(--sea-green);
        color: white;
    }
</style>

<!-- CABECERA ESTÁNDAR PREMIUM -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 d-flex align-items-center gap-4">
                <div class="shadow-sm" style="background-color: white; padding: 12px; border-radius: 20px;">
                    <img src="{{ asset('images/petmatch_logo_modoclaro.png') }}" alt="PetMatch Logo" style="height: 70px; width: auto; display: block;">
                </div>
                
                <div>
                    <h1 class="mb-1" style="font-weight: 800; letter-spacing: -1px;">Encuentra su pareja ideal</h1>
                    <p class="mb-0 fs-5" style="color: var(--sea-green); font-weight: 500;">Descubre perros idoneos para hacer match</p>
                </div>
            </div>
            
            
            
            <!-- Derecha: Botonera -->
            <div class="col-md-4 text-md-end mt-4 mt-md-0 d-flex gap-3 justify-content-md-end">
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-bold d-flex align-items-center" style="border-width: 2px;">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
            
        </div>
    </div>
</div>

<div class="container mb-5" style="margin-top: -3.5rem; position: relative; z-index: 10;">
    
    <!-- TARJETA DE FILTROS FLOTANTE -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="stat-card p-4 p-md-4 shadow-lg border-0" style="border-radius: 20px;">
                <form action="{{ route('busqueda.index') }}" method="GET" class="row g-3 align-items-end">
                    
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold text-uppercase px-1" style="letter-spacing: 1px;"><i class="fas fa-search me-1" style="color: var(--sea-green);"></i> Raza</label>
                        <input type="text" name="raza" class="form-control p-3" placeholder="Ej: Golden, Bulldog..." value="{{ request('raza') }}" style="border-radius: 12px; border-color: rgba(0, 129, 72, 0.2);">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold text-uppercase px-1" style="letter-spacing: 1px;"><i class="fas fa-venus-mars me-1" style="color: var(--camel);"></i> Sexo</label>
                        <select name="sexo" class="form-select p-3" style="border-radius: 12px; border-color: rgba(0, 129, 72, 0.2); cursor: pointer;">
                            <option value="">Todos</option>
                            <option value="M" {{ request('sexo') == 'M' ? 'selected' : '' }}>Macho</option>
                            <option value="H" {{ request('sexo') == 'H' ? 'selected' : '' }}>Hembra</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold text-uppercase px-1" style="letter-spacing: 1px;"><i class="fas fa-map-marker-alt me-1" style="color: var(--pure-red);"></i> Ciudad</label>
                        <input type="text" name="ciudad" class="form-control p-3" placeholder="Ej: Madrid" value="{{ request('ciudad') }}" style="border-radius: 12px; border-color: rgba(0, 129, 72, 0.2);">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm" style="border-radius: 12px; padding: 14px 0;">
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- RESULTADOS (CUADRÍCULA DE PERROS) -->
    <div class="row g-4">
        @forelse($perros as $perro)
            <div class="col-md-6 col-lg-4">
                <div class="stat-card explore-card border-0 h-100 d-flex flex-column overflow-hidden shadow-sm" style="border-radius: 20px;">
                    
                    <!-- Imagen y Badges -->
                    <div class="position-relative" style="height: 250px; background-color: var(--bg-secondary);">
                        
                        <!-- Badge Ciudad (Efecto Cristal) -->
                        <div class="position-absolute top-0 start-0 m-3 badge rounded-pill px-3 py-2 shadow-sm d-flex align-items-center" 
                             style="background-color: rgba(255, 255, 255, 0.85); color: var(--deep-forest); backdrop-filter: blur(5px); font-size: 0.8rem;">
                            <i class="fas fa-map-marker-alt me-1" style="color: var(--pure-red);"></i> 
                            {{ $perro->usuario->ciudad ?? 'Desconocida' }}
                        </div>

                        <!-- Badge Sexo -->
                        <div class="position-absolute top-0 end-0 m-3 badge rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                             style="background-color: {{ $perro->sexo == 'M' ? 'var(--deep-forest)' : 'var(--tiger-orange)' }}; width: 35px; height: 35px; font-size: 1rem;">
                            <i class="fas fa-{{ $perro->sexo == 'M' ? 'mars' : 'venus' }} text-white"></i>
                        </div>

                        @if($perro->foto_url)
                            <img src="{{ asset('storage/' . $perro->foto_url) }}" class="w-100 h-100 object-fit-cover" alt="{{ $perro->nombre }}">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-dog fa-4x" style="color: var(--camel); opacity: 0.5;"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Información del Perro -->
                    <div class="p-4 pt-4 text-center d-flex flex-column flex-grow-1">
                        <h3 class="fw-bold mb-0" style="color: var(--deep-forest); letter-spacing: -0.5px;">
                            {{ $perro->nombre }} <span class="text-muted fw-normal fs-5">, {{ $perro->edad }}</span>
                        </h3>
                        <p class="small text-uppercase fw-bold mb-4 mt-1" style="color: var(--sea-green); letter-spacing: 1px;">
                            {{ $perro->raza }}
                        </p>

                        <!-- Mini Estadísticas -->
                        <div class="d-flex justify-content-center gap-2 mb-4 pb-3 border-bottom" style="border-color: rgba(0, 129, 72, 0.1) !important;">
                            <div class="flex-grow-1 p-2 rounded-3" style="background-color: var(--bg-main);">
                                <small class="text-muted text-uppercase d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Peso</small>
                                <span class="fw-bold" style="color: var(--deep-forest);">{{ $perro->peso }} kg</span>
                            </div>
                            <div class="flex-grow-1 p-2 rounded-3" style="background-color: var(--bg-main);">
                                <small class="text-muted text-uppercase d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Dueño</small>
                                <span class="fw-bold d-block text-truncate mx-auto" style="color: var(--deep-forest); max-width: 90px;">
                                    <i class="fas fa-user-circle small me-1" style="color: var(--camel);"></i>{{ $perro->usuario->nombre ?? 'Usuario' }}
                                </span>
                            </div>
                        </div>

                        <p class="small text-muted text-truncate px-2 mb-4">
                            {{ $perro->descripción ?: 'El dueño no ha añadido ninguna descripción. ¡Anímate a conocerlo!' }}
                        </p>

                        <!-- Botón Ver Perfil -->
                        <div class="mt-auto">
                            <a href="{{ route('perros.show', $perro) }}" class="btn btn-ver-perfil w-100 rounded-pill py-2 fw-bold text-uppercase" style="letter-spacing: 1px;">
                                 Ver Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        @empty
            <!-- ESTADO VACÍO (Sin resultados) -->
            <div class="col-12 text-center py-5 mt-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 100px; height: 100px; background-color: var(--bg-secondary);">
                    <i class="fas fa-search fa-3x" style="color: var(--tiger-orange);"></i>
                </div>
                <h3 class="fw-bold mb-2" style="color: var(--deep-forest); letter-spacing: -1px;">No hemos encontrado parejas</h3>
                <p class="text-muted mb-4">Prueba a cambiar la raza, el sexo o la ciudad para ver más resultados.</p>
                <a href="{{ route('busqueda.index') }}" class="btn rounded-pill px-4 py-2 fw-bold" style="border-color: var(--deep-forest); color: var(--deep-forest);">
                    Limpiar Filtros
                </a>
            </div>
        @endforelse
    </div>

    <!-- PAGINACIÓN -->
<div class="pagination-container mt-5 mb-5">
    {{ $perros->links() }}
</div>
</div>

@endsection