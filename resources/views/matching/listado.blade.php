@extends('layouts.app')

@section('content')

<style>
    /* Diseño de las pestañas (Tabs) */
    .custom-nav-pills .nav-link {
        border-radius: 30px;
        color: var(--deep-forest);
        font-weight: 700;
        padding: 12px 24px;
        margin: 0 8px;
        background-color: white;
        border: 1px solid rgba(0, 129, 72, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    
    .custom-nav-pills .nav-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .custom-nav-pills .nav-link.active {
        background-color: var(--sea-green);
        color: white;
        border-color: var(--sea-green);
        box-shadow: 0 8px 20px rgba(0, 129, 72, 0.2);
    }

    /* Avatares entrelazados (Duo Images) */
    .duo-avatar-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 110px;
        margin-bottom: 1rem;
    }

    .duo-img {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        background-color: var(--bg-secondary);
        transition: transform 0.3s ease;
    }

    .duo-img.left {
        z-index: 2;
        transform: translateX(15px);
    }
    .duo-img.left:hover {
        transform: translateX(15px) scale(1.05);
        z-index: 4;
    }

    .duo-img.right {
        z-index: 1;
        transform: translateX(-15px);
    }

    .center-badge-icon {
        position: absolute;
        z-index: 3;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid white;
        font-size: 1.1rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Tarjetas de Match */
    .match-stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .match-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 129, 72, 0.1) !important;
    }
</style>

<!-- CABECERA INMERSIVA -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 d-flex align-items-center gap-4">
                <div class="shadow-sm" style="background-color: white; padding: 12px; border-radius: 20px;">
                    <img src="{{ asset('images/petmatch_logo_modoclaro.png') }}" alt="PetMatch Logo" style="height: 70px; width: auto; display: block;">
                </div>
                
                <div>
                    <h1 class="mb-1" style="font-weight: 800; letter-spacing: -1px;">Mis Solicitudes</h1>
                    <p class="mb-0 fs-5" style="color: var(--sea-green); font-weight: 500;">Gestiona las conexiones y solicitudes de tus mascotas</p>
                </div>
            </div>
            
            <div class="col-md-4 text-md-end mt-4 mt-md-0 d-flex gap-3 justify-content-md-end">
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-bold d-flex align-items-center" style="border-width: 2px;">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
            
        </div>
    </div>
</div>




<div class="container mb-5" style="margin-top: -2rem; position: relative; z-index: 10;">

    <!-- Alerta de Éxito -->
    @if(session('success'))
        <div class="alert shadow-sm border-0 mb-4" style="background-color: var(--bg-secondary); color: var(--deep-forest); border-radius: 15px;">
            <i class="fas fa-check-circle me-2" style="color: var(--sea-green);"></i> {{ session('success') }}
        </div>
    @endif

    <!-- NAVEGACIÓN (Tabs) -->
    <ul class="nav nav-pills custom-nav-pills justify-content-center mb-5" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active d-flex align-items-center" id="pills-recibidas-tab" data-bs-toggle="pill" data-bs-target="#pills-recibidas" type="button" role="tab">
                Nuevas <span class="badge rounded-pill ms-2" style="background-color: var(--pure-red);">{{ $recibidas->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-flex align-items-center" id="pills-aceptados-tab" data-bs-toggle="pill" data-bs-target="#pills-aceptados" type="button" role="tab">
                Aceptados <span class="badge rounded-pill ms-2" style="background-color: var(--sea-green);">{{ $aceptados->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-flex align-items-center" id="pills-enviadas-tab" data-bs-toggle="pill" data-bs-target="#pills-enviadas" type="button" role="tab">
                Enviadas <span class="badge bg-secondary rounded-pill ms-2">{{ $enviadas->count() }}</span>
            </button>
        </li>
    </ul>

    <!-- CONTENIDO DE LAS PESTAÑAS -->
    <div class="tab-content" id="pills-tabContent">
        
        <!-- 1. SOLICITUDES RECIBIDAS -->
        <div class="tab-pane fade show active" id="pills-recibidas" role="tabpanel">
            <div class="row g-4">
                @forelse($recibidas as $match)
                    <div class="col-md-6 col-lg-4">
                        <div class="stat-card match-stat-card border-0 h-100 text-center d-flex flex-column p-4" style="border-radius: 20px;">
                            
                            <div class="duo-avatar-wrapper mt-2">
                                <a href="{{ route('perros.show', $match->perro1) }}" title="Ver perfil de {{ $match->perro1->nombre }}">
                                    <img src="{{ $match->perro1->foto_url ? asset('storage/'.$match->perro1->foto_url) : asset('images/default-dog.png') }}" class="duo-img left" alt="{{ $match->perro1->nombre }}">
                                </a>
                                <div class="center-badge-icon" style="background-color: white; color: var(--pure-red);">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <img src="{{ $match->perro2->foto_url ? asset('storage/'.$match->perro2->foto_url) : asset('images/default-dog.png') }}" class="duo-img right" alt="{{ $match->perro2->nombre }}">
                            </div>
                            
                            <div class="flex-grow-1 d-flex flex-column">
                                <h5 class="fw-bold mb-1" style="color: var(--deep-forest);">
                                    ¡<a href="{{ route('perros.show', $match->perro1) }}" class="text-decoration-none" style="color: var(--tiger-orange);">{{ $match->perro1->nombre }}</a> quiere conocer a {{ $match->perro2->nombre }}!
                                </h5>
                                <p class="small mb-4" style="color: var(--sea-green); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $match->perro1->usuario->ciudad ?? 'Ciudad desconocida' }}
                                </p>
                                
                                <div class="mt-auto d-flex justify-content-center gap-2">
                                    <form action="{{ route('matching.rechazar', $match) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        <button type="submit" class="btn w-100 rounded-pill fw-bold" style="background-color: rgba(239, 41, 23, 0.1); color: var(--pure-red);" title="Rechazar">
                                            <i class="fas fa-times me-1"></i> Rechazar
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('matching.aceptar', $match) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        <button type="submit" class="btn w-100 rounded-pill fw-bold" style="background-color: var(--sea-green); color: white;" title="Aceptar Match">
                                            <i class="fas fa-heart me-1"></i> Aceptar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 mt-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 100px; height: 100px; background-color: var(--bg-secondary);">
                            <i class="fas fa-inbox fa-3x" style="color: var(--tiger-orange);"></i>
                        </div>
                        <h3 class="fw-bold mb-2" style="color: var(--deep-forest); letter-spacing: -1px;">No tienes solicitudes nuevas</h3>
                        <p class="text-muted mb-0">Cuando alguien quiera hacer match con tus perros, aparecerá aquí.</p>
                    </div>
                @endempty
            </div>
        </div>

        <!-- 2. MATCHES ACEPTADOS -->
        <div class="tab-pane fade" id="pills-aceptados" role="tabpanel">
            
            @php $misPerrosIds = auth()->user()->perros->pluck('id'); @endphp
            
            <div class="row g-4">
                @forelse($aceptados as $match)
                    @php
                        $miPerro = $misPerrosIds->contains($match->perro_id_1) ? $match->perro1 : $match->perro2;
                        $otroPerro = $misPerrosIds->contains($match->perro_id_1) ? $match->perro2 : $match->perro1;
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="stat-card match-stat-card border-0 h-100 text-center d-flex flex-column p-4 position-relative overflow-hidden" style="border-radius: 20px;">
                            
                            <!-- Borde superior decorativo -->
                            <div class="position-absolute top-0 start-0 w-100" style="height: 6px; background-color: var(--sea-green);"></div>

                            <div class="duo-avatar-wrapper mt-3">
                                <img src="{{ $miPerro->foto_url ? asset('storage/'.$miPerro->foto_url) : asset('images/default-dog.png') }}" class="duo-img left" alt="{{ $miPerro->nombre }}">
                                <div class="center-badge-icon" style="background-color: var(--sea-green); color: white; border-color: white;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <img src="{{ $otroPerro->foto_url ? asset('storage/'.$otroPerro->foto_url) : asset('images/default-dog.png') }}" class="duo-img right" alt="{{ $otroPerro->nombre }}">
                            </div>
                            
                            <div class="flex-grow-1 d-flex flex-column">
                                <h5 class="fw-bold mb-1" style="color: var(--deep-forest);">¡Es un Match Oficial!</h5>
                                <p class="text-muted small mb-4"><strong>{{ $miPerro->nombre }}</strong> y <strong>{{ $otroPerro->nombre }}</strong></p>
                                
                                <div class="mt-auto">
                                    <!-- Enlazado directamente a la conversación -->
                                    <a href="{{ route('mensajes.show', $match->id) }}" class="btn w-100 rounded-pill fw-bold" style="background-color: rgba(0, 129, 72, 0.1); color: var(--sea-green);">
                                        <i class="fas fa-comment-dots me-2"></i> Enviar Mensaje
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 mt-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 100px; height: 100px; background-color: var(--bg-secondary);">
                            <i class="fas fa-check-double fa-3x" style="color: var(--sea-green);"></i>
                        </div>
                        <h3 class="fw-bold mb-2" style="color: var(--deep-forest); letter-spacing: -1px;">Aún no tienes matches aceptados</h3>
                        <p class="text-muted mb-4">Sigue explorando perfiles para encontrar a la pareja ideal.</p>
                        <a href="{{ route('busqueda.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">¡Ir a explorar!</a>
                    </div>
                @endempty
            </div>
        </div>

        <!-- 3. SOLICITUDES ENVIADAS -->
        <div class="tab-pane fade" id="pills-enviadas" role="tabpanel">
            <div class="row g-4">
                @forelse($enviadas as $match)
                    <div class="col-md-6 col-lg-4">
                        <div class="stat-card border-0 h-100 text-center d-flex flex-column p-4" style="border-radius: 20px; opacity: 0.85;">
                            
                            <div class="duo-avatar-wrapper mt-2">
                                <img src="{{ $match->perro1->foto_url ? asset('storage/'.$match->perro1->foto_url) : asset('images/default-dog.png') }}" class="duo-img left" alt="{{ $match->perro1->nombre }}">
                                <div class="center-badge-icon" style="background-color: var(--bg-main); color: var(--camel); border-color: white;">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                                <img src="{{ $match->perro2->foto_url ? asset('storage/'.$match->perro2->foto_url) : asset('images/default-dog.png') }}" class="duo-img right" alt="{{ $match->perro2->nombre }}">
                            </div>
                            
                            <div class="flex-grow-1 d-flex flex-column">
                                <h5 class="fw-bold mb-2" style="color: var(--deep-forest);">Esperando respuesta...</h5>
                                <div class="p-2 rounded-3 mt-auto" style="background-color: var(--bg-main);">
                                    <p class="text-muted small mb-0">Le enviaste un like a <strong>{{ $match->perro2->nombre }}</strong> con <strong>{{ $match->perro1->nombre }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 mt-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 100px; height: 100px; background-color: var(--bg-secondary);">
                            <i class="fas fa-paper-plane fa-3x" style="color: var(--camel);"></i>
                        </div>
                        <h3 class="fw-bold mb-2" style="color: var(--deep-forest); letter-spacing: -1px;">No has enviado solicitudes</h3>
                        <p class="text-muted mb-0">Tus invitaciones pendientes aparecerán en este apartado.</p>
                    </div>
                @endempty
            </div>
        </div>

    </div>
</div>
@endsection