@extends('layouts.app')

@section('content')

<style>
    /* Contenedor principal del chat */
    .chat-wrapper {
        height: 75vh;
        min-height: 500px;
        max-height: 800px;
        border-radius: 24px;
        background-color: var(--bg-secondary, #fcfcf9);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* Burbujas de mensaje generales */
    .message-bubble {
        max-width: 85%; /* AMPLIADO: Antes era 75%, ahora tienen más espacio para crecer */
        padding: 12px 18px;
        font-size: 0.95rem;
        line-height: 1.4;
        position: relative;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
    }

    /* Mis mensajes (Emisor - Fondo Verde) */
    .message-me {
        justify-content: flex-end;
    }
    .message-me .message-bubble {
        background-color: var(--sea-green);
        color: white;
        border-radius: 20px 20px 4px 20px;
        padding-right: 26px; /* AÑADIDO: Empuja el fondo verde más hacia la derecha para que el texto no se vea pegado */
    }

    /* Mensajes del otro (Receptor - Fondo Blanco) */
    .message-other {
        justify-content: flex-start;
    }
    .message-other .message-bubble {
        background-color: white;
        color: var(--deep-forest);
        border: 1px solid rgba(0, 129, 72, 0.1);
        border-radius: 20px 20px 20px 4px;
        padding-left: 20px; /* Un poco de aire también para los mensajes del otro */
    }

    /* Input del chat */
    .chat-input {
        border-radius: 30px !important;
        padding: 12px 20px !important;
        border: 1px solid rgba(0, 129, 72, 0.2) !important;
        background-color: white;
        transition: all 0.3s;
    }
    .chat-input:focus {
        border-color: var(--sea-green) !important;
        box-shadow: 0 0 0 4px rgba(0, 129, 72, 0.1) !important;
        outline: none;
    }

    /* Botón de enviar */
    .btn-send {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: var(--sea-green);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s, background-color 0.2s;
        flex-shrink: 0;
    }
    .btn-send:hover {
        transform: scale(1.05);
        background-color: var(--deep-forest);
    }
</style>

<div class="container py-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            
            <!-- TARJETA DEL CHAT -->
            <div class="stat-card border-0 shadow-lg chat-wrapper">
                
                <!-- 1. CABECERA -->
                <div class="p-3 p-md-4 border-bottom d-flex align-items-center" style="background-color: white; z-index: 10;">
                    <a href="{{ route('mensajes.index') }}" class="text-decoration-none me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background-color: var(--bg-main); color: var(--deep-forest);">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    
                    <div class="position-relative me-3">
                        <img src="{{ $otroPerro->foto_url ? asset('storage/'.$otroPerro->foto_url) : asset('images/default-dog.png') }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 50px; height: 50px; border: 2px solid white;" alt="{{ $otroPerro->nombre }}">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 12px; height: 12px;"></span>
                    </div>
                    
                    <div class="flex-grow-1">
                        <h5 class="mb-0 fw-bold" style="color: var(--deep-forest); letter-spacing: -0.5px;">{{ $otroPerro->nombre }}</h5>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">
                            <i class="fas fa-user-circle me-1" style="color: var(--tiger-orange);"></i> Dueño: {{ $otroPerro->usuario->nombre }}
                        </small>
                    </div>
                    
                    <div class="ms-auto d-none d-sm-block">
                        <a href="{{ route('perros.show', $otroPerro) }}" class="btn btn-sm rounded-pill px-3 fw-bold" style="background-color: rgba(0, 129, 72, 0.1); color: var(--sea-green);">
                            Ver Perfil
                        </a>
                    </div>
                </div>

                <!-- 2. CUERPO DE MENSAJES -->
                <!-- Reduje un poco el padding derecho (pe-2 en vez de p-4) para que los mensajes lleguen más al borde de la pantalla -->
                <div class="flex-grow-1 p-3 p-md-4 pe-md-3 overflow-auto" id="chatBody">
                    
                    <!-- Insignia de Match -->
                    <div class="text-center mb-4 mt-2">
                        <span class="badge rounded-pill px-4 py-2 shadow-sm fw-bold" style="background-color: rgba(0, 129, 72, 0.1); color: var(--sea-green); font-size: 0.8rem;">
                            <i class="fas fa-heart me-1" style="color: var(--pure-red);"></i> ¡Match conseguido el {{ $matching->updated_at->format('d/m/Y') }}!
                        </span>
                    </div>

                    <!-- Variable de memoria para las fechas -->
                    @php $fechaAnterior = null; @endphp

                    @forelse($mensajes as $mensaje)
                        <!-- Lógica de Fechas -->
                        @php
                            $fechaActual = $mensaje->created_at->format('Y-m-d');
                        @endphp

                        @if($fechaActual !== $fechaAnterior)
                            <div class="text-center my-4">
                                <span class="badge rounded-pill shadow-sm px-3 py-1 fw-bold text-uppercase" style="background-color: white; color: var(--sea-green); border: 1px solid rgba(0, 129, 72, 0.1); font-size: 0.65rem; letter-spacing: 1px;">
                                    @if($mensaje->created_at->isToday())
                                        Hoy
                                    @elseif($mensaje->created_at->isYesterday())
                                        Ayer
                                    @else
                                        {{ $mensaje->created_at->format('d/m/Y') }}
                                    @endif
                                </span>
                            </div>
                            @php $fechaAnterior = $fechaActual; @endphp
                        @endif
                        <!-- Fin Lógica de Fechas -->

                        <div class="d-flex w-100 mb-3 {{ $mensaje->perro_emisor_id == $miPerro->id ? 'message-me' : 'message-other' }}">
                            
                            <div class="d-flex flex-column {{ $mensaje->perro_emisor_id == $miPerro->id ? 'align-items-end' : 'align-items-start' }}">
                                <div class="message-bubble shadow-sm">
                                    {{ $mensaje->contenido }}
                                </div>
                                <span class="small text-muted mt-1" style="font-size: 0.7rem;">
                                    {{ $mensaje->created_at->format('H:i') }}
                                </span>
                            </div>

                        </div>
                    @empty
                        <!-- Estado sin mensajes -->
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 opacity-75">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px; background-color: rgba(0, 129, 72, 0.05);">
                                <i class="fas fa-hand-sparkles fa-2x" style="color: var(--tiger-orange);"></i>
                            </div>
                            <h5 class="fw-bold" style="color: var(--deep-forest);">Rompe el hielo</h5>
                            <p class="text-muted small text-center px-4">Escribe el primer mensaje para saludar a {{ $otroPerro->nombre }} y a su dueño.</p>
                        </div>
                    @endforelse

                </div>

                <!-- 3. FOOTER (INPUT) -->
                <div class="p-3 p-md-4 bg-white border-top" style="border-color: rgba(0, 129, 72, 0.1) !important;">
                    <form action="{{ route('mensajes.store', $matching) }}" method="POST">
                        @csrf
                        <input type="hidden" name="mi_perro_id" value="{{ $miPerro->id }}">
                        
                        <div class="d-flex gap-2 align-items-center">
                            <input type="text" name="contenido" class="form-control chat-input" placeholder="Escribe un mensaje..." required autocomplete="off" autofocus>
                            <button type="submit" class="btn-send shadow-sm">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    // Script para hacer scroll automáticamente hasta el último mensaje
    document.addEventListener("DOMContentLoaded", function() {
        var chatBody = document.getElementById("chatBody");
        chatBody.scrollTop = chatBody.scrollHeight;
    });
</script>

@endsection