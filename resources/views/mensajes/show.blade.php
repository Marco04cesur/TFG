@extends('layouts.app')

@section('content')


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