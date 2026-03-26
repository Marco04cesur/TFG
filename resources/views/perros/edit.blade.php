@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Editar Perro</h1>
    <form action="{{ route('perros.update',$perro) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Raza:</label>
            <input type="text" name="raza" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Sexo:</label>
            <select name="sexo" class="form-control" required>
                <option value="{{ $perro->nombre}}">-- Selecciona --</option>
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Edad (años):</label>
            <input type="number" name="edad" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Peso (kg):</label>
            <input type="number" step="0.1" name="peso" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Crear Perro</button>
    </form>
</div>
@endsection
