@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Tus Matches ❤️</h2>

    <div class="row">
        @forelse($matches as $match)
            @php
                // Lógica para saber cuál de los dos perros no es el mío
                $perroMatch = in_array($match->perro_id_1, $misPerrosIds) 
                              ? $match->perro2 
                              : $match->perro1;
            @endphp
            
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    @if($perroMatch)
                        <img src="{{ asset('storage/' . $perroMatch->foto_url) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-dog.png') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body text-center">
                        <h5 class="card-title">¡Match con {{ $perroMatch->nombre }}!</h5>
                        <p class="small text-muted">{{ $perroMatch->raza }}</p>
                        <a href="{{ route('mensajes.show', $match->id) }}" class="btn btn-primary">
                            Enviar Mensaje
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Aún no tienes coincidencias. ¡Sigue buscando en el Matching!</p>
                <a href="{{ route('matching.show') }}" class="btn btn-outline-primary">Ir al Matching</a>
            </div>
        @endforelse
    </div>
</div>
@endsection