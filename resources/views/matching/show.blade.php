@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if($perro)
                <div class="card shadow-lg">
                    <img src="{{ asset('storage/' . $perro->foto_url) }}" class="card-img-top" alt="{{ $perro->nombre }}">
                    <div class="card-body text-center">
                        <h2 class="card-title">{{ $perro->nombre }}, {{ $perro->edad }} años</h2>
                        <p class="text-muted">{{ $perro->raza }} | {{ $perro->sexo == 'M' ? 'Macho' : 'Hembra' }}</p>
                        <p>{{ $perro->descripcion }}</p>

                        <div class="d-flex justify-content-around mt-4">
                            <form action="{{ route('matching.dislike', $perro->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-lg rounded-circle">✖</button>
                            </form>

                            <form action="{{ route('matching.like', $perro) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg rounded-circle">❤</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h3>¡Vaya! No hay más perros disponibles por ahora.</h3>
                    <p>Vuelve más tarde para ver nuevas mascotas.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@stop