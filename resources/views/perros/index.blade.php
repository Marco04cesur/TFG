@extends('layouts.app')

@section('content')

<style>
    .btn-invert {
        background-color: var(--sea-green);
        color: white !important;
        border: 2px solid var(--sea-green);
        transition: all 0.3s ease;
    }
    
    .btn-invert:hover {
        background-color: white !important;
        color: var(--sea-green) !important;
        border-color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 d-flex align-items-center gap-4">
                <div class="shadow-sm" style="background-color: white; padding: 12px; border-radius: 20px;">
                    <img src="{{ asset('images/petmatch_logo_modoclaro.png') }}" alt="PetMatch Logo" style="height: 70px; width: auto; display: block;">
                </div>
                
                <div>
                    <h1 class="mb-1" style="font-weight: 800; letter-spacing: -1px;">Mis Perros Registrados</h1>
                    <p class="mb-0 fs-5" style="color: var(--sea-green); font-weight: 500;">Administra tus mascotas y su disponibilidad</p>
                </div>
            </div>
            
            <div class="col-md-4 text-md-end mt-4 mt-md-0 d-flex gap-3 justify-content-md-end">
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-bold d-flex align-items-center" style="border-width: 2px;">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>

                <a href="{{ route('perros.create') }}" class="btn-invert rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center text-decoration-none">
                    <i class="fas fa-plus me-2"></i> Nuevo Perro
                </a>
            </div>
            
        </div>
    </div>
</div>

<div class="container mb-5" style="margin-top: -3.5rem; position: relative; z-index: 10;">
    
    <!-- TARJETA DE FILTROS FLOTANTE -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-7">
            <div class="stat-card p-4 shadow-sm border-0" style="border-radius: 20px;">
                <form action="{{ route('perros.index') }}" method="GET" class="row g-3 align-items-end">
                    
                    <div class="col-md-5">
                        <label class="form-label text-muted small fw-bold text-uppercase px-1" style="letter-spacing: 1px;"><i class="fas fa-search me-1" style="color: var(--sea-green);"></i> Raza</label>
                        <input type="text" name="raza" class="form-control p-3" placeholder="Ej: Golden, Bulldog..." value="{{ request('raza') }}" style="border-radius: 12px; border-color: rgba(0, 129, 72, 0.2);">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold text-uppercase px-1" style="letter-spacing: 1px;"><i class="fas fa-venus-mars me-1" style="color: var(--camel);"></i> Sexo</label>
                        <select name="sexo" class="form-select p-3" style="border-radius: 12px; border-color: rgba(0, 129, 72, 0.2); cursor: pointer;">
                            <option value="">Todos</option>
                            <option value="M" {{ request('sexo') == 'M' ? 'selected' : '' }}>Macho</option>
                            <option value="H" {{ request('sexo') == 'H' ? 'selected' : '' }}>Hembra</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm" style="border-radius: 12px; padding: 14px 0;">
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="container mb-5" >
    
    @if(session('success'))
        <div class="alert shadow-sm border-0 mb-5" style="background-color: var(--bg-secondary); color: var(--deep-forest); border-radius: 15px;">
            <i class="fas fa-check-circle me-2" style="color: var(--sea-green);"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse($perros as $perro)
            <div class="col-md-6 col-lg-4">
                <div class="stat-card border-0 h-100 d-flex flex-column overflow-hidden" style="border-radius: 20px;">
                    
                    <div class="position-relative" style="height: 240px; background-color: #f8f9fa;">
                        
                        <div class="position-absolute top-0 start-0 m-3 badge rounded-pill px-3 py-2 shadow-sm" 
                             style="background-color: {{ $perro->disponible ? 'var(--sea-green)' : '#9ca3af' }}; font-size: 0.8rem; font-weight: 600;">
                            {{ $perro->disponible ? 'Disponible para Match' : 'No Disponible' }}
                        </div>

                        <div class="position-absolute top-0 end-0 m-3 badge rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                             style="background-color: {{ $perro->sexo == 'M' ? 'var(--deep-forest)' : 'var(--tiger-orange)' }}; width: 35px; height: 35px; font-size: 1rem;">
                            <i class="fas fa-{{ $perro->sexo == 'M' ? 'mars' : 'venus' }} text-white"></i>
                        </div>

                        @if($perro->foto_url)
                            <img src="{{ asset('storage/' . $perro->foto_url) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $perro->nombre }}">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background-color: var(--bg-secondary);">
                                <i class="fas fa-dog fa-4x" style="color: var(--camel); opacity: 0.5;"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h4 class="fw-bold mb-0" style="color: var(--deep-forest); letter-spacing: -0.5px;">{{ $perro->nombre }}</h4>
                        </div>
                        <span class="small fw-bold text-uppercase mb-4" style="color: var(--sea-green); letter-spacing: 1px;">{{ $perro->raza }}</span>
                        
                        <div class="d-flex gap-2 mb-4">
                            <div class="flex-grow-1 p-2 rounded-3 text-center" style="background-color: var(--bg-main);">
                                <small class="d-block text-uppercase fw-bold" style="color: var(--sea-green); font-size: 0.7rem; letter-spacing: 1px;">Edad</small>
                                <span class="fw-bold" style="color: var(--deep-forest);">{{ $perro->edad }} años</span>
                            </div>
                            <div class="flex-grow-1 p-2 rounded-3 text-center" style="background-color: var(--bg-main);">
                                <small class="d-block text-uppercase fw-bold" style="color: var(--sea-green); font-size: 0.7rem; letter-spacing: 1px;">Peso</small>
                                <span class="fw-bold" style="color: var(--deep-forest);">{{ $perro->peso }} kg</span>
                            </div>
                        </div>

                        <div class="mb-4 flex-grow-1">
                            <strong class="small text-uppercase d-block mb-1" style="color: var(--deep-forest); letter-spacing: 1px;">Descripción</strong>
                            <p class="small text-muted mb-0" style="line-height: 1.6;">
                                {{ $perro->descripción ?: 'No hay descripción disponible para esta mascota.' }}
                            </p>
                        </div>

                        <div class="d-flex justify-content-center gap-2 pt-3 border-top" style="border-color: rgba(0, 129, 72, 0.1) !important;">
                            
                            <a href="{{ route('perros.show', $perro) }}" class="btn btn-sm rounded-pill px-3 fw-bold" style="background-color: rgba(0, 129, 72, 0.1); color: var(--sea-green);">
                                <i class="fas fa-eye me-1"></i> Perfil
                            </a>
                            
                            <a href="{{ route('perros.edit', $perro) }}" class="btn btn-sm rounded-pill px-3 fw-bold" style="background-color: rgba(239, 138, 23, 0.1); color: var(--tiger-orange);">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            
                            <form action="{{ route('perros.destroy', $perro) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar a {{ $perro->nombre }} de tu cuenta?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm rounded-pill px-3 fw-bold" style="background-color: rgba(239, 41, 23, 0.1); color: var(--pure-red); border: none;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        @empty
            <div class="col-12 text-center py-5 mt-4">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 100px; height: 100px; background-color: var(--bg-secondary);">
                        <i class="fas fa-dog fa-3x" style="color: var(--sea-green);"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-2" style="color: var(--deep-forest); letter-spacing: -1px;">Aún no tienes perros</h3>
                <p class="text-muted mb-4">Registra a tu primera mascota para que otros dueños puedan encontrarla.</p>
                <a href="{{ route('perros.create') }}" class="btn-invert rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-block text-decoration-none">
                    <i class="fas fa-plus me-2"></i> Añadir mi primer perro
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection