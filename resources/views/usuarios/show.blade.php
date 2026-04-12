@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f7f6; }
    
    .owner-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0 80px;
        border-radius: 0 0 40px 40px;
        color: white;
        text-align: center;
    }

    .owner-avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        object-fit: cover;
        margin-top: -65px;
        background-color: white;
    }

    .owner-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 30px;
        margin-top: -50px;
        position: relative;
        z-index: 10;
        text-align: center;
    }

    .dog-mini-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        border: none;
        text-decoration: none;
        color: inherit;
        display: block;
        background: white;
    }

    .dog-mini-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        color: inherit;
    }

    .dog-mini-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
</style>

<div style="position: absolute; top: 20px; left: 20px; z-index: 20;">
    <a href="{{ url()->previous() }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm text-primary">
        <i class="fas fa-arrow-left me-2"></i> Volver
    </a>
</div>

<div class="owner-header">
    <div class="container">
        <h2 class="fw-bold mb-0">Perfil del Dueño</h2>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="owner-card mb-5">
                @if($usuario->avatar)
                    <img src="{{ asset('storage/' . $usuario->avatar) }}" class="owner-avatar mb-3" alt="Avatar">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nombre) }}&background=764ba2&color=fff&size=150" class="owner-avatar mb-3" alt="Avatar">
                @endif
                
                <h3 class="fw-bold mb-1">{{ $usuario->nombre }}</h3>
                <p class="text-muted fs-5 mb-3">
                    <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $usuario->ciudad ?? 'Ciudad no especificada' }}
                </p>
                <div class="d-inline-block bg-light rounded-pill px-4 py-2 text-muted fw-bold small">
                    <i class="fas fa-paw me-2 text-primary"></i> Miembro de PetMatch
                </div>
            </div>

            <h4 class="fw-bold mb-4 border-bottom pb-2">Los peludos de {{ $usuario->nombre }}</h4>

            <div class="row g-4">
                @forelse($perros as $perro)
                    <div class="col-md-6">
                        <a href="{{ route('perros.show', $perro) }}" class="dog-mini-card">
                            @if($perro->foto_url)
                                <img src="{{ asset('storage/' . $perro->foto_url) }}" class="dog-mini-img" alt="{{ $perro->nombre }}">
                            @else
                                <img src="{{ asset('images/default-dog.png') }}" class="dog-mini-img" style="background: #eee;">
                            @endif
                            <div class="p-3 text-center">
                                <h5 class="fw-bold mb-1">{{ $perro->nombre }} 
                                    @if($perro->sexo == 'M') <i class="fas fa-mars text-primary"></i> @else <i class="fas fa-venus text-danger"></i> @endif
                                </h5>
                                <p class="text-muted small mb-0">{{ $perro->raza }} • {{ $perro->edad }} años</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">Parece que no hay perros disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection