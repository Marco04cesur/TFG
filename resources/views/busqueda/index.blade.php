@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f7f6; }
    
    /* Cabecera de Exploración */
    .search-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 50px 0 100px;
        border-radius: 0 0 40px 40px;
        color: white;
        text-align: center;
        position: relative;
    }

    /* Tarjeta Flotante del Buscador */
    .filter-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        margin-top: -60px; /* Hace que flote sobre la cabecera */
        padding: 25px;
        position: relative;
        z-index: 10;
        border: none;
    }

    .form-control-custom, .form-select-custom {
        border-radius: 15px;
        padding: 14px 20px;
        background-color: #f8f9fa;
        border: 2px solid transparent;
        transition: all 0.3s;
        font-weight: 500;
    }

    .form-control-custom:focus, .form-select-custom:focus {
        background-color: white;
        border-color: #764ba2;
        box-shadow: 0 0 0 0.25rem rgba(118, 75, 162, 0.15);
    }

    /* Tarjetas de Descubrimiento (Mascotas) */
    .match-card {
        border: none;
        border-radius: 25px;
        background: white;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .match-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    .match-image-wrapper {
        position: relative;
        height: 280px; /* Más alto para que la foto luzca */
        overflow: hidden;
        background-color: #eee;
    }

    .match-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .match-card:hover .match-image {
        transform: scale(1.08); /* Efecto zoom suave */
    }

    /* Etiquetas Flotantes en la foto */
    .location-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.95);
        color: #444;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: bold;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        backdrop-filter: blur(5px);
    }

    .gender-badge-float {
        position: absolute;
        bottom: -20px;
        right: 25px;
        width: 55px;
        height: 55px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        z-index: 2;
    }

    /* Botón de Match / Ver Perfil */
    .btn-match {
        background: linear-gradient(135deg, #FF6B35 0%, #F9A03F 100%); /* Naranja vibrante para el Match */
        color: white;
        border: none;
        border-radius: 50px;
        padding: 12px;
        font-weight: bold;
        transition: all 0.3s;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    .btn-match:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(255, 107, 53, 0.35);
        color: white;
    }
</style>

<div class="search-header">
    <div class="container">
        <h1 class="display-4 fw-bold mb-2">Encuentra a su pareja ideal</h1>
        <p class="fs-5 opacity-75">Descubre perros cerca de ti listos para hacer match</p>
    </div>
</div>

<div class="container mb-5">
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div style="position: absolute; top: 20px; left: 20px; z-index: 20;">
                <a href="{{ url('/dashboard') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm text-primary">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>

            <div class="card filter-card">
                <form action="{{ route('busqueda.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold text-uppercase px-2"><i class="fas fa-search me-1"></i> Buscar por Raza</label>
                        <input type="text" name="raza" class="form-control form-control-custom w-100" placeholder="Ej: Golden, Bulldog..." value="{{ request('raza') }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold text-uppercase px-2"><i class="fas fa-venus-mars me-1"></i> Sexo</label>
                        <select name="sexo" class="form-select form-select-custom w-100">
                            <option value="">Todos</option>
                            <option value="M" {{ request('sexo') == 'M' ? 'selected' : '' }}>Macho</option>
                            <option value="H" {{ request('sexo') == 'H' ? 'selected' : '' }}>Hembra</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold text-uppercase px-2"><i class="fas fa-map-marker-alt me-1"></i> Ciudad</label>
                        <input type="text" name="ciudad" class="form-control form-control-custom w-100" placeholder="Ej: Madrid" value="{{ request('ciudad') }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100" style="border-radius: 15px; padding: 14px; font-weight: bold;">
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        @forelse($perros as $perro)
            <div class="col-md-6 col-lg-4">
                <div class="card match-card">
                    <div class="match-image-wrapper">
                        <div class="location-badge">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i> 
                            {{ $perro->usuario->ciudad ?? 'Ciudad no especificada' }}
                        </div>

                        @if($perro->foto_url)
                            <img src="{{ asset('storage/' . $perro->foto_url) }}" class="match-image" alt="{{ $perro->nombre }}">
                        @else
                            <img src="{{ asset('images/default-dog.png') }}" class="match-image" alt="Sin foto">
                        @endif

                        <div class="gender-badge-float">
                            @if($perro->sexo == 'M')
                                <i class="fas fa-mars" style="color: #3498db;"></i>
                            @else
                                <i class="fas fa-venus" style="color: #e84393;"></i>
                            @endif
                        </div>
                    </div>

                    <div class="card-body pt-4 text-center d-flex flex-column">
                        <h3 class="fw-bold mb-0">{{ $perro->nombre }} <span class="text-muted fw-normal fs-5">, {{ $perro->edad }}</span></h3>
                        <p class="text-primary fw-bold mb-3">{{ $perro->raza }}</p>

                        <div class="d-flex justify-content-center gap-4 mb-3 pb-3 border-bottom">
                            <div>
                                <small class="text-muted text-uppercase d-block" style="font-size: 0.7rem;">Peso</small>
                                <span class="fw-bold text-dark">{{ $perro->peso }} kg</span>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase d-block" style="font-size: 0.7rem;">Dueño</small>
                                <span class="fw-bold text-dark"><i class="fas fa-user-circle me-1"></i> {{ $perro->usuario->nombre ?? 'Usuario' }}</span>
                            </div>
                        </div>

                        <p class="small text-muted text-truncate px-2 mb-4">{{ $perro->descripción ?: 'Sin descripción.' }}</p>

                        <div class="mt-auto">
                            <a href="{{ route('perros.show', $perro) }}" class="btn btn-match w-100 shadow-sm">
                                <i class="fas fa-heart me-2"></i> Ver Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 mt-5">
                <i class="fas fa-search-minus fa-4x text-muted opacity-25 mb-3"></i>
                <h3 class="text-muted fw-bold">No hemos encontrado parejas</h3>
                <p class="text-muted">Prueba a cambiar los filtros de búsqueda o la ciudad para ver más resultados.</p>
                <a href="{{ route('busqueda.index') }}" class="btn btn-outline-primary rounded-pill px-4 mt-2">Limpiar Filtros</a>
            </div>
        @endforelse
    </div>

    @if(method_exists($perros, 'links'))
        <div class="d-flex justify-content-center mt-5">
            {{ $perros->links() }}
        </div>
    @endif
</div>
@endsection