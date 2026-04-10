@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f7f6; }
    
    .page-header {
        background: white;
        padding: 40px 0;
        border-bottom: 1px solid #e0e6ed;
        margin-bottom: 40px;
        border-radius: 0 0 30px 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .dog-card {
        border: none;
        border-radius: 25px;
        transition: all 0.3s ease;
        background: white;
        overflow: hidden;
    }

    .dog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }

    .dog-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .dog-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .dog-card:hover .dog-image {
        transform: scale(1.1);
    }

    .status-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .gender-icon {
        position: absolute;
        bottom: 1px;
        right: 20px;
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 2;
    }

    .text-macho { color: #3498db; }
    .text-hembra { color: #e84393; }

    .btn-action-custom {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: none;
    }

    .btn-add-dog {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: bold;
        transition: all 0.3s;
    }

    .btn-add-dog:hover {
        transform: scale(1.05);
        color: white;
        box-shadow: 0 8px 20px rgba(118, 75, 162, 0.3);
    }
</style>

<div class="page-header shadow-sm">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="fw-bold mb-0">Mis Perros registrados 🐶</h1>
                <p class="text-muted mb-0">Administra tus mascotas y su disponibilidad</p>
            </div>
            
            <div class="d-flex gap-2">
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center">
                    <i class="fas fa-arrow-left me-2"></i> Dashboard
                </a>

                <a href="{{ route('perros.create') }}" class="btn btn-add-dog shadow">
                    <i class="fas fa-plus me-2"></i> Registrar nuevo perro
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse($perros as $perro)
            <div class="col-md-6 col-lg-4">
                <div class="card dog-card shadow-sm h-100">
                    <div class="dog-image-container">
                        <span class="status-badge {{ $perro->disponible ? 'bg-success' : 'bg-secondary' }} text-white">
                            {{ $perro->disponible ? 'Disponible' : 'No disponible' }}
                        </span>

                        @if($perro->foto_url)
                            <img src="{{ asset('storage/' . $perro->foto_url) }}" class="dog-image" alt="{{ $perro->nombre }}">
                        @else
                            <img src="{{ asset('images/default-dog.png') }}" class="dog-image" alt="Sin foto">
                        @endif

                        <div class="gender-icon">
                            <i class="fas fa-{{ $perro->sexo == 'M' ? 'mars text-macho' : 'venus text-hembra' }}"></i>
                        </div>
                    </div>

                    <div class="card-body pt-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="fw-bold mb-0">{{ $perro->nombre }}</h4>
                            <span class="text-primary small fw-bold">{{ $perro->raza }}</span>
                        </div>
                        
                        <div class="row g-0 py-3 my-3 border-top border-bottom">
                            <div class="col-6 border-end text-center">
                                <small class="text-muted d-block small text-uppercase">Edad</small>
                                <span class="fw-bold">{{ $perro->edad }} años</span>
                            </div>
                            <div class="col-6 text-center">
                                <small class="text-muted d-block small text-uppercase">Peso</small>
                                <span class="fw-bold">{{ $perro->peso }} kg</span>
                            </div>
                        </div>

                        <p class="card-text">
                            <strong class="small text-muted text-uppercase d-block mb-1">Descripción:</strong>
                            <span class="text-muted small">{{ $perro->descripción ?: 'Sin descripción disponible.' }}</span>
                        </p>
                    </div>

                    <div class="card-footer bg-white border-0 pb-4">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('perros.show', $perro) }}" class="btn btn-action-custom bg-info bg-opacity-10 text-info" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('perros.edit', $perro) }}" class="btn btn-action-custom bg-warning bg-opacity-10 text-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('perros.destroy', $perro) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar a {{ $perro->nombre }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action-custom bg-danger bg-opacity-10 text-danger" title="Borrar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-dog fa-4x text-muted opacity-25"></i>
                </div>
                <h3 class="text-muted">No tienes perros registrados todavía.</h3>
                <p class="text-muted">¡Comienza registrando a tu mejor amigo para buscarle pareja!</p>
                <a href="{{ route('perros.create') }}" class="btn btn-primary rounded-pill px-4 mt-2">Registrar mi primer perro</a>
            </div>
        @endforelse
    </div>
</div>
@endsection