@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f7f6; }

    .chat-container {
        max-width: 800px;
        margin: 20px auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 80vh; /* Ocupa el 80% de la pantalla */
    }

    /* Cabecera Fija del Chat */
    .chat-header {
        background: white;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 15px;
        z-index: 10;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }

    .chat-header-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #11998e;
    }

    /* Zona de Mensajes (Scrolleable) */
    .chat-body {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto;
        background-color: #f4f7f6;
        background-image: radial-gradient(#d5dfdc 1px, transparent 1px); /* Trama de puntitos sutil */
        background-size: 20px 20px;
    }

    /* Burbujas de Chat */
    .message-wrapper {
        display: flex;
        margin-bottom: 15px;
        flex-direction: column;
    }

    .message-wrapper.me {
        align-items: flex-end;
    }

    .message-wrapper.other {
        align-items: flex-start;
    }

    .message-bubble {
        max-width: 75%;
        padding: 12px 18px;
        border-radius: 20px;
        position: relative;
        font-size: 0.95rem;
        line-height: 1.4;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .message-wrapper.me .message-bubble {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        border-bottom-right-radius: 4px; /* Hace el "pico" del bocadillo */
    }

    .message-wrapper.other .message-bubble {
        background: white;
        color: #333;
        border-bottom-left-radius: 4px; /* Hace el "pico" del bocadillo */
        border: 1px solid #e0e6ed;
    }

    .message-time {
        font-size: 0.7rem;
        margin-top: 5px;
        opacity: 0.7;
    }

    .message-wrapper.me .message-time { color: #6c757d; padding-right: 5px; }
    .message-wrapper.other .message-time { color: #6c757d; padding-left: 5px; }

    /* Barra de Escribir (Footer Fijo) */
    .chat-footer {
        background: white;
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }

    .chat-input-group {
        background: #f8f9fa;
        border-radius: 50px;
        padding: 5px 5px 5px 20px;
        display: flex;
        align-items: center;
        border: 1px solid #e0e6ed;
    }

    .chat-input {
        border: none;
        background: transparent;
        flex-grow: 1;
        outline: none;
        box-shadow: none;
    }

    .chat-input:focus {
        outline: none;
        box-shadow: none;
    }

    .btn-send {
        background: #11998e;
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s;
    }

    .btn-send:hover {
        transform: scale(1.05);
        background: #0d7d73;
    }
</style>

<div class="container">
    <div class="chat-container">
        
        <div class="chat-header">
            <a href="{{ route('mensajes.index') }}" class="text-muted text-decoration-none me-2">
                <i class="fas fa-arrow-left fa-lg"></i>
            </a>
            <img src="{{ $otroPerro->foto_url ? asset('storage/'.$otroPerro->foto_url) : asset('images/default-dog.png') }}" class="chat-header-img">
            <div>
                <h5 class="mb-0 fw-bold">{{ $otroPerro->nombre }}</h5>
                <small class="text-muted">Dueño: {{ $otroPerro->usuario->nombre }}</small>
            </div>
            
            <div class="ms-auto">
                <a href="{{ route('perros.show', $otroPerro) }}" class="btn btn-sm btn-outline-secondary rounded-pill">Ver Perfil</a>
            </div>
        </div>

        <div class="chat-body" id="chatBody">
            
            <div class="text-center mb-4">
                <span class="badge bg-secondary bg-opacity-10 text-muted px-3 py-2 rounded-pill fw-normal">
                    ¡Match conseguido el {{ $matching->updated_at->format('d/m/Y') }}! Di hola 👋
                </span>
            </div>

            @forelse($mensajes as $mensaje)
                <div class="message-wrapper {{ $mensaje->perro_emisor_id == $miPerro->id ? 'me' : 'other' }}">
                    <div class="message-bubble">
                        {{ $mensaje->contenido }}
                    </div>
                    <div class="message-time">
                        {{ $mensaje->created_at->format('H:i') }}
                    </div>
                </div>
            @empty
                <div class="text-center mt-5">
                    <img src="{{ asset('images/default-dog.png') }}" style="width: 100px; opacity: 0.5; filter: grayscale(1);" class="mb-3">
                    <h5 class="text-muted fw-bold">No hay mensajes todavía</h5>
                    <p class="text-muted small">Rompe el hielo y escribe el primer mensaje con {{ $miPerro->nombre }}.</p>
                </div>
            @endforelse

        </div>

        <div class="chat-footer">
            <form action="{{ route('mensajes.store', $matching) }}" method="POST">
                @csrf
                <input type="hidden" name="mi_perro_id" value="{{ $miPerro->id }}">
                
                <div class="chat-input-group">
                    <input type="text" name="contenido" class="chat-input" placeholder="Escribe un mensaje..." required autocomplete="off" autofocus>
                    <button type="submit" class="btn-send shadow-sm">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatBody = document.getElementById("chatBody");
        chatBody.scrollTop = chatBody.scrollHeight;
    });
</script>

@endsection