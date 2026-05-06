@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <!-- BOTÓN DE VOLVER (Dinámico: Mis Perros o Búsqueda) -->
    <div class="mb-4">
        @if($perro->usuario_id == auth()->id())
            <a href="{{ route('perros.index') }}" class="text-decoration-none fw-bold" style="color: var(--sea-green); transition: color 0.3s;">
                <i class="fas fa-arrow-left me-2"></i> Volver a Mis Perros
            </a>
        @else
            <a href="{{ route('busqueda.index') }}" class="text-decoration-none fw-bold" style="color: var(--sea-green); transition: color 0.3s;">
                <i class="fas fa-arrow-left me-2"></i> Volver a Búsqueda
            </a>
        @endif
    </div>

    <!-- TARJETA DE PERFIL (Diseño Dividido) -->
    <div class="stat-card border-0 shadow-lg overflow-hidden" style="border-radius: 24px;">
        <div class="row g-0">
            
            <!-- MITAD IZQUIERDA: IMAGEN -->
            <div class="col-md-5 position-relative" style="min-height: 400px; background-color: var(--bg-secondary);">
                
                @if($perro->foto_url)
                    <img src="{{ asset('storage/' . $perro->foto_url) }}" class="w-100 h-100 position-absolute object-fit-cover" alt="Foto de {{ $perro->nombre }}">
                @else
                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center position-absolute text-center p-4">
                        <i class="fas fa-dog fa-5x mb-3" style="color: var(--camel); opacity: 0.5;"></i>
                        <p class="text-muted fw-bold mb-0">Sin fotografía</p>
                    </div>
                @endif
                
                <!-- Insignia del Dueño (Flotando sobre la foto abajo a la izquierda) -->
                <div class="position-absolute bottom-0 start-0 m-4 z-1">
                    @if($perro->usuario)
                        <a href="{{ route('usuarios.show', $perro->usuario->id) }}" class="btn btn-sm btn-light rounded-pill px-3 py-2 shadow-sm fw-bold d-flex align-items-center text-decoration-none" style="color: var(--deep-forest); background: rgba(255,255,255,0.9); backdrop-filter: blur(5px);">
                            <i class="fas fa-user-circle me-2" style="color: var(--sea-green);"></i> 
                            Dueño: {{ $perro->usuario->nombre }}
                        </a>
                    @else
                        <div class="btn btn-sm btn-light rounded-pill px-3 py-2 shadow-sm fw-bold d-flex align-items-center" style="color: var(--deep-forest); opacity: 0.8;">
                            <i class="fas fa-user-circle me-2"></i> Dueño: Desconocido
                        </div>
                    @endif
                </div>
            </div>

            <!-- MITAD DERECHA: INFORMACIÓN Y ACCIONES -->
            <div class="col-md-7 p-4 p-md-5 d-flex flex-column">
                
                <!-- Encabezado del Perfil -->
                <div class="mb-4 pb-4 border-bottom" style="border-color: rgba(0, 129, 72, 0.1) !important;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h1 class="fw-bold mb-0" style="color: var(--deep-forest); letter-spacing: -1px; font-size: 2.5rem;">
                            {{ $perro->nombre }}
                        </h1>
                        <!-- Icono de Sexo Grande -->
                        <div class="d-flex align-items-center justify-content-center rounded-circle shadow-sm" 
                             style="background-color: {{ $perro->sexo == 'M' ? 'var(--deep-forest)' : 'var(--tiger-orange)' }}; width: 45px; height: 45px;">
                            <i class="fas fa-{{ $perro->sexo == 'M' ? 'mars' : 'venus' }} fa-lg text-white"></i>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <span class="fs-6 fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;">
                            <i class="fas fa-dna me-1"></i> {{ $perro->raza }}
                        </span>
                        <span class="text-muted">|</span>
                        <span class="fs-6 fw-bold text-muted">
                            <i class="fas fa-map-marker-alt me-1" style="color: var(--pure-red);"></i> {{ $perro->usuario->ciudad ?? 'Ciudad desconocida' }}
                        </span>
                    </div>
                </div>

                <!-- Cuadrícula de Datos Rápidos -->
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-3 rounded-4 text-center" style="background-color: var(--bg-main);">
                            <i class="fas fa-birthday-cake mb-2 fs-4" style="color: var(--tiger-orange);"></i>
                            <span class="d-block small fw-bold text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Edad</span>
                            <span class="fw-bold fs-5" style="color: var(--deep-forest);">{{ $perro->edad }} años</span>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="p-3 rounded-4 text-center" style="background-color: var(--bg-main);">
                            <i class="fas fa-weight-hanging mb-2 fs-4" style="color: var(--sea-green);"></i>
                            <span class="d-block small fw-bold text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Peso</span>
                            <span class="fw-bold fs-5" style="color: var(--deep-forest);">{{ $perro->peso }} kg</span>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-5 flex-grow-1">
                    <h5 class="fw-bold mb-3" style="color: var(--deep-forest);"><i class="fas fa-quote-left text-muted me-2" style="opacity: 0.3;"></i> Sobre {{ $perro->nombre }}</h5>
                    <p class="text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                        {{ $perro->descripción ?: 'El dueño aún no ha escrito una descripción para este perrito, pero seguro que es adorable.' }}
                    </p>
                </div>

                <!-- ZONA DE ACCIÓN: Dueño VS Visitante -->
                <div class="mt-auto pt-4 border-top" style="border-color: rgba(0, 129, 72, 0.1) !important;">
                    
                    @if($perro->usuario_id == auth()->id())
                        <!-- ERES EL DUEÑO -->
                        <div class="text-center">
                            <p class="text-muted small fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">Gestión de mascota</p>
                            <a href="{{ route('perros.edit', $perro) }}" class="btn rounded-pill px-5 py-3 fw-bold w-100" style="background-color: var(--sea-green); color: white; font-size: 1.1rem;">
                                <i class="fas fa-edit me-2"></i> Editar Perfil
                            </a>
                        </div>
                    @else
                        <!-- ERES UN VISITANTE (SISTEMA DE MATCH) -->
                        <div class="match-section p-4 rounded-4" style="background-color: var(--bg-main);">
                            <h5 class="fw-bold mb-3 text-center" style="color: var(--deep-forest);">¿Hacemos Match? </h5>
                            
                            <!-- Alertas de Match -->
                            @if(session('success'))
                                <div class="alert alert-success rounded-3 small fw-bold text-center border-0 shadow-sm mb-3">
                                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger rounded-3 small fw-bold text-center border-0 shadow-sm mb-3">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('matching.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="perro_id_2" value="{{ $perro->id }}">
                                
                                @if($misPerros->isEmpty())
                                    <div class="text-center">
                                        <p class="small text-muted mb-3">Necesitas registrar al menos un perro para poder solicitar un match.</p>
                                        <a href="{{ route('perros.create') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold" style="border-color: var(--tiger-orange); color: var(--tiger-orange);">
                                            Registrar mi perro
                                        </a>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold small text-uppercase">Selecciona tu perro:</label>
                                        <select name="perro_id_1" class="form-select form-select-lg" style="border-radius: 12px; font-size: 1rem; border-color: rgba(0, 129, 72, 0.2); cursor: pointer;" required>
                                            <option value="" disabled selected>-- Elige con quién presentarlo --</option>
                                            @foreach($misPerros as $miPerro)
                                                <option value="{{ $miPerro->id }}">{{ $miPerro->nombre }} ({{ $miPerro->raza }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn rounded-pill w-100 py-3 fw-bold" style="background-color: var(--pure-red); color: white; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(239, 41, 23, 0.3);">
                                        <i class="fas fa-heart me-2"></i> Solicitar Match
                                    </button>
                                @endif
                            </form>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>
@endsection