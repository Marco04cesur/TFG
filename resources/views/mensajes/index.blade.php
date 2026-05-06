@extends('layouts.app')

@section('content')

<style>
    /* Estilos Globales para el Header Recto y Uniforme */
   

    /* Tarjetas de Chat Rectas */
    .chat-row-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid rgba(0, 129, 72, 0.1);
        border-radius: 0; /* Recto */
        background-color: white;
        text-decoration: none;
        color: inherit;
        display: block;
        
    }
    
    .chat-row-card:hover {
        transform: translateX(5px); /* Efecto de desplazamiento lateral en lugar de elevación */
        box-shadow: 5px 5px 0px var(--sea-green); /* Sombra sólida estilo retro/moderno */
        border-color: var(--sea-green);
        color: inherit;
    }

    .chat-avatar-wrapper {
        position: relative;
        width: 70px;
        height: 70px;
        flex-shrink: 0;
    }

    .chat-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0; /* Avatar también recto para máxima consistencia */
        border: 2px solid var(--bg-main);
    }

    .match-icon-badge {
        position: absolute;
        bottom: -5px;
        right: -5px;
        background-color: var(--pure-red);
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 0; /* Recto */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        border: 2px solid white;
    }

    .btn-rect {
        border-radius: 0 !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

<!-- CABECERA UNIFORME Y RECTA -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 d-flex align-items-center gap-4">
                <div class="shadow-sm" style="background-color: white; padding: 12px; border-radius: 20px;">
                    <img src="{{ asset('images/petmatch_logo_modoclaro.png') }}" alt="PetMatch Logo" style="height: 70px; width: auto; display: block;">
                </div>
                
                <div>
                    <h1 class="mb-1" style="font-weight: 800; letter-spacing: -1px;">MENSAJES</h1>
                    <p class="mb-0 fs-5" style="color: var(--sea-green); font-weight: 500;">Gestiona tus conversaciones activas</p>
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


<!-- LISTA DE CHATS -->
<div class="container mb-5" style="margin-top: -3.5rem; position: relative; z-index: 10;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="d-flex flex-column gap-3">
                @forelse($matches as $match)
                    @php
                        $misPerrosIds = auth()->user()->perros->pluck('id');
                        
                        if ($misPerrosIds->contains($match->perro_id_1)) {
                            $miPerro = $match->perro1;
                            $otroPerro = $match->perro2;
                        } else {
                            $miPerro = $match->perro2;
                            $otroPerro = $match->perro1;
                        }
                    @endphp

                    <a href="{{ route('mensajes.show', $match->id) }}" class="chat-row-card p-3 shadow-sm">
                        <div class="d-flex align-items-center gap-4">
                            
                            <!-- Avatar de la Pareja (Cuadrado) -->
                            <div class="chat-avatar-wrapper shadow-sm">
                                <img src="{{ $otroPerro->foto_url ? asset('storage/'.$otroPerro->foto_url) : asset('images/default-dog.png') }}" class="chat-avatar" alt="{{ $otroPerro->nombre }}">
                                <div class="match-icon-badge"><i class="fas fa-heart"></i></div>
                            </div>

                            <!-- Info -->
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h4 class="fw-bold mb-0 text-truncate" style="color: var(--deep-forest); text-transform: uppercase; font-size: 1.1rem;">
                                        {{ $otroPerro->nombre }} 
                                        <span class="text-muted fw-normal ms-1" style="font-size: 0.8rem; text-transform: none;">con {{ $otroPerro->usuario->nombre }}</span>
                                    </h4>
                                    
                                    <span class="d-none d-md-inline-block fw-bold px-2 py-1" style="background-color: var(--bg-main); color: var(--sea-green); font-size: 0.65rem; border: 1px solid rgba(0, 129, 72, 0.1);">
                                        COMO: {{ strtoupper($miPerro->nombre) }}
                                    </span>
                                </div>
                                
                                <p class="mb-0 text-truncate text-muted small">
                                    <i class="fas fa-reply me-1" style="color: var(--tiger-orange);"></i>
                                    Haz clic para abrir el chat con {{ $otroPerro->nombre }}...
                                </p>
                            </div>

                            <!-- Indicador -->
                            <div class="d-none d-md-block ps-3 border-start">
                                <i class="fas fa-chevron-right text-muted opacity-50"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    <!-- ESTADO VACÍO RECTO -->
                    <div class="p-5 text-center bg-white shadow-sm border-top border-4" style="border-color: var(--sea-green);">
                        <div class="mb-4">
                            <i class="fas fa-paper-plane fa-3x opacity-25" style="color: var(--sea-green);"></i>
                        </div>
                        <h3 class="fw-bold text-uppercase" style="color: var(--deep-forest); letter-spacing: 1px;">Sin mensajes aún</h3>
                        <p class="text-muted mb-4">Cuando tus solicitudes de match sean aceptadas, aparecerán aquí.</p>
                        <a href="{{ route('matching.listado') }}" class="btn btn-primary btn-rect px-4 py-2">
                            VER MIS MATCHES
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection