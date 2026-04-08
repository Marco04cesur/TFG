@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Mis Perros registrados</h1>
        <a href="{{ route('perros.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Registrar nuevo perro
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($perros as $perro)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div style="height: 200px; overflow: hidden;">
                        @if($perro->foto_url)
                            <img src="{{ asset('storage/' . $perro->foto_url) }}" class="card-img-top" alt="{{ $perro->nombre }}" style="object-fit: cover; height: 100%; width: 100%;">
                        @else
                            <img src="{{ asset('images/default-dog.png') }}" class="card-img-top" alt="Sin foto" style="object-fit: cover; height: 100%; width: 100%;">
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between">
                            {{ $perro->nombre }}
                            <span class="badge {{ $perro->disponible ? 'bg-success' : 'bg-secondary' }}">
                                {{ $perro->disponible ? 'Disponible' : 'No disponible' }}
                            </span>
                        </h5>
                        
                        <p class="card-text mb-1"><strong>Raza:</strong> {{ $perro->raza }}</p>
                        <p class="card-text mb-1"><strong>Sexo:</strong> {{ $perro->sexo == 'M' ? 'Macho' : 'Hembra' }}</p>
                        <p class="card-text mb-1"><strong>Edad:</strong> {{ $perro->edad }} años</p>
                        <p class="card-text mb-1"><strong>Peso:</strong> {{ $perro->peso }} kg</p>
                        
                        <hr>
                        
                        <p class="card-text">
                            <strong>Descripción:</strong><br>
                            <small class="text-muted">{{ $perro->descripción ?: 'Sin descripción.' }}</small>
                        </p>
                    </div>

                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                        <div class="btn-group w-100">
                            <a href="{{ route('perros.show', $perro) }}" class="btn btn-outline-info btn-sm">Ver</a>
                            <a href="{{ route('perros.edit', $perro) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
                            
                            <form action="{{ route('perros.destroy', $perro) }}" method="POST" onsubmit="return confirm('¿Eliminar a {{ $perro->nombre }}?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Borrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No tienes perros registrados todavía.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection