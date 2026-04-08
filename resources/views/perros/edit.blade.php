@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-center">Editar a {{ $perro->nombre }}</h4>
                </div>
                <div class="card-body p-4">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('perros.update', $perro) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $perro->nombre) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Raza</label>
                                <input type="text" name="raza" class="form-control" value="{{ old('raza', $perro->raza) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sexo</label>
                                <select name="sexo" class="form-select" required>
                                    <option value="M" {{ old('sexo', $perro->sexo) == 'M' ? 'selected' : '' }}>Macho</option>
                                    <option value="H" {{ old('sexo', $perro->sexo) == 'H' ? 'selected' : '' }}>Hembra</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Edad (años)</label>
                                <input type="number" name="edad" class="form-control" value="{{ old('edad', $perro->edad) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Peso (kg)</label>
                                <input type="number" step="0.1" name="peso" class="form-control" value="{{ old('peso', $perro->peso) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripción" class="form-control" rows="4">{{ old('descripción', $perro->descripción) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Foto actual</label>
                            <div class="mb-2">
                                @if($perro->foto_url)
                                    <img src="{{ asset('storage/' . $perro->foto_url) }}" width="150" class="img-thumbnail rounded">
                                @else
                                    <span class="text-muted small">No hay foto subida.</span>
                                @endif
                            </div>
                            <label class="form-label">Cambiar foto (dejar vacío si no quieres cambiarla)</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar cambios</button>
                            <a href="{{ route('perros.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection