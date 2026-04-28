@extends('layouts.app')

@section('content')


<div style="position: absolute; top: 20px; left: 20px; z-index: 20;">
    @if($perro->usuario_id == auth()->id())
        <a href="{{ route('perros.index') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow">
            <i class="fas fa-arrow-left me-2"></i> Mis Perros
        </a>
    @else
        <a href="{{ route('busqueda.index') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow">
            <i class="fas fa-arrow-left me-2"></i> Volver a Buscar
        </a>
    @endif
</div>

<div class="profile-header">
    @if($perro->foto_url)
        <img src="{{ asset('storage/' . $perro->foto_url) }}" class="profile-header-img" alt="{{ $perro->nombre }}">
    @else
        <img src="{{ asset('images/default-dog.png') }}" class="profile-header-img" alt="Sin foto" style="background: #ccc;">
    @endif

    <div class="profile-header-content d-flex justify-content-between align-items-end">
        <div>
            <h1 class="display-4 fw-bold mb-0">
                {{ $perro->nombre }}
                @if($perro->sexo == 'M')
                    <i class="fas fa-mars" style="color: #667eea; font-size: 2rem;"></i>
                @else
                    <i class="fas fa-venus" style="color: #e84393; font-size: 2rem;"></i>
                @endif
            </h1>
            <p class="fs-4 mb-0"><i class="fas fa-map-marker-alt text-danger me-2"></i> {{ $perro->usuario->ciudad ?? 'Ciudad desconocida' }}</p>
        </div>
        
        @if($perro->usuario)
            <a href="{{ route('usuarios.show', $perro->usuario->id) }}" class="owner-badge text-white text-decoration-none shadow-sm" style="transition: all 0.3s; cursor: pointer;">
                <i class="fas fa-user-circle me-2"></i> Dueño: <strong>{{ $perro->usuario->nombre }}</strong>
                <i class="fas fa-external-link-alt ms-2 small opacity-75"></i>
            </a>
            <style>
                .owner-badge:hover { 
                    background: rgba(255,255,255,0.3); 
                    transform: translateY(-2px); 
                    box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
                }
            </style>
        @else
            <div class="owner-badge">
                <i class="fas fa-user me-2"></i> Dueño: <strong>Desconocido</strong>
            </div>
        @endif
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="info-card">
                <div class="row g-3 mb-4 border-bottom pb-4">
                    <div class="col-4">
                        <div class="stat-box">
                            <i class="fas fa-dna text-primary mb-2 fa-2x"></i>
                            <h6 class="text-muted text-uppercase small mb-0">Raza</h6>
                            <h5 class="fw-bold mb-0 text-dark">{{ $perro->raza }}</h5>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <i class="fas fa-birthday-cake text-warning mb-2 fa-2x"></i>
                            <h6 class="text-muted text-uppercase small mb-0">Edad</h6>
                            <h5 class="fw-bold mb-0 text-dark">{{ $perro->edad }} años</h5>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <i class="fas fa-weight text-success mb-2 fa-2x"></i>
                            <h6 class="text-muted text-uppercase small mb-0">Peso</h6>
                            <h5 class="fw-bold mb-0 text-dark">{{ $perro->peso }} kg</h5>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h4 class="fw-bold mb-3"><i class="fas fa-quote-left text-muted me-2"></i> Sobre {{ $perro->nombre }}</h4>
                    <p class="fs-5 text-muted" style="line-height: 1.8;">
                        {{ $perro->descripción ?: 'El dueño aún no ha escrito una descripción para este perrito, pero seguro que es adorable.' }}
                    </p>
                </div>

                <div class="text-center mt-5 pt-4 border-top">
                    
                    @if($perro->usuario_id == auth()->id())
                        <p class="text-muted mb-3">Este es tu perro. ¿Quieres actualizar sus datos?</p>
                        <a href="{{ route('perros.edit', $perro) }}" class="btn btn-outline-primary rounded-pill px-5 fw-bold">
                            <i class="fas fa-edit me-2"></i> Editar Perfil
                        </a>
                    @else
                        <h4 class="fw-bold mb-4">¿Te gustaría que tus perros conocieran a {{ $perro->nombre }}?</h4>
                        
                        @if(session('success'))
                    <div class="alert alert-success rounded-pill fw-bold text-center border-0 shadow-sm mb-4">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger rounded-pill fw-bold text-center border-0 shadow-sm mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('matching.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="perro_id_2" value="{{ $perro->id }}">
                    
                    @if($misPerros->isEmpty())
                        <div class="alert alert-warning rounded-4 small text-center">
                            Necesitas tener al menos un perro registrado para poder solicitar un match.
                            <a href="{{ route('perros.create') }}" class="fw-bold text-warning-emphasis d-block mt-2">Registrar mi primer perro</a>
                        </div>
                    @else
                        <div class="mb-4 text-start">
                            <label class="form-label text-muted fw-bold small text-uppercase ms-2">¿Con quién quieres presentarlo?</label>
                            <select name="perro_id_1" class="form-select form-select-lg" style="border-radius: 15px;" required>
                                <option value="">-- Selecciona a tu perro --</option>
                                @foreach($misPerros as $miPerro)
                                    <option value="{{ $miPerro->id }}">{{ $miPerro->nombre }} ({{ $miPerro->raza }})</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-match-large w-100">
                            <i class="fas fa-heart me-2"></i> Solicitar Match
                        </button>
                    @endif
                </form>
                    @endif

                </div>

            </div>

        </div>
    </div>
</div>
@endsection