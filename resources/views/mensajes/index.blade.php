@extends('layouts.app')

@section('content')


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