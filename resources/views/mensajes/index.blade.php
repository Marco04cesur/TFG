@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f7f6; }

    .page-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); /* Verde esmeralda para los mensajes */
        padding: 40px 0;
        border-radius: 0 0 30px 30px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 10px 25px rgba(56, 239, 125, 0.3);
    }

    .chat-list-card {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .chat-list-card:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        background-color: #fcfcfc;
    }

    .chat-avatar-wrapper {
        position: relative;
        width: 70px;
        height: 70px;
    }

    .chat-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f8f9fa;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .match-icon-badge {
        position: absolute;
        bottom: 0;
        right: -5px;
        background: #FF6B35;
        color: white;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        border: 2px solid white;
    }

    .chat-info {
        flex-grow: 1;
        min-width: 0; /* Necesario para que funcione el truncate */
    }

    .chat-name {
        font-weight: bold;
        color: #333;
        font-size: 1.1rem;
        margin-bottom: 2px;
    }

    .chat-preview {
        color: #6c757d;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-open-chat {
        background: #f8f9fa;
        color: #11998e;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: bold;
        transition: all 0.3s;
    }

    .chat-list-card:hover .btn-open-chat {
        background: #11998e;
        color: white;
    }
</style>

<div class="page-header text-center relative">
    <div class="container position-relative">
        <div style="position: absolute; top: 0; left: 15px;">
            <a href="{{ url('/dashboard') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm text-dark">
                <i class="fas fa-arrow-left me-2"></i> Dashboard
            </a>
        </div>
        <h1 class="display-5 fw-bold mb-0"><i class="fas fa-comments me-2"></i> Mensajes</h1>
        <p class="fs-5 opacity-75 mt-2">Tus conversaciones activas</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex flex-column gap-3">
                @forelse($matches as $match)
                    @php
                        // Sacamos el ID de nuestro perro (basado en el usuario logueado)
                        $misPerrosIds = auth()->user()->perros->pluck('id');
                        
                        // Determinamos quién es mi perro y quién es el otro
                        if ($misPerrosIds->contains($match->perro_id_1)) {
                            $miPerro = $match->perro1;
                            $otroPerro = $match->perro2;
                        } else {
                            $miPerro = $match->perro2;
                            $otroPerro = $match->perro1;
                        }
                        
                        // Si tienes un modelo Mensaje con relación, aquí sacaríamos el último.
                        // $ultimoMensaje = $match->mensajes->last();
                    @endphp

                    <a href="{{ route('mensajes.show', $match->id) }}" class="chat-list-card p-3">
                        <div class="d-flex align-items-center gap-3">
                            
                            <div class="chat-avatar-wrapper">
                                <img src="{{ $otroPerro->foto_url ? asset('storage/'.$otroPerro->foto_url) : asset('images/default-dog.png') }}" class="chat-avatar">
                                <div class="match-icon-badge"><i class="fas fa-heart"></i></div>
                            </div>

                            <div class="chat-info">
                                <div class="d-flex justify-content-between align-items-baseline mb-1">
                                    <h5 class="chat-name">{{ $otroPerro->nombre }} <span class="text-muted small fw-normal">({{ $otroPerro->usuario->nombre }})</span></h5>
                                    <small class="text-muted">Hablando como {{ $miPerro->nombre }}</small>
                                </div>
                                
                                <p class="chat-preview mb-0">
                                    <i class="fas fa-comment-dots text-muted me-1"></i> 
                                    Haz clic para abrir la conversación y saludar a {{ $otroPerro->nombre }}...
                                </p>
                            </div>

                            <div class="d-none d-md-block">
                                <span class="btn-open-chat">Abrir Chat</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5 bg-white shadow-sm" style="border-radius: 20px;">
                        <i class="fas fa-paper-plane fa-3x text-muted opacity-25 mb-3"></i>
                        <h4 class="text-muted fw-bold">Aún no hay mensajes</h4>
                        <p class="text-muted">Cuando aceptes un match, aparecerá aquí para que podáis hablar.</p>
                        <a href="{{ route('matching.listado') }}" class="btn btn-outline-success rounded-pill px-4 mt-2">Ir a Mis Matches</a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection