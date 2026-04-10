@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
    }

    .card {
        border-radius: 25px;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
        max-width: 700px;
        width: 100%;
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-label {
        font-weight: bold;
        color: #444;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }

    .form-label i {
        margin-right: 8px;
        color: #764ba2;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 15px;
        background-color: #f8f9fa;
        border: 2px solid #f8f9fa;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: #e0e6ed;
        box-shadow: none;
    }

    .dog-icon-header {
        width: 70px;
        height: 70px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -65px auto 20px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        color: #764ba2;
        border: 4px solid white;
    }

    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 15px;
        border-radius: 50px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
        color: white;
    }

    .btn-back {
        border-radius: 50px;
        padding: 10px 20px;
        font-weight: bold;
        color: #764ba2;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #f8f9fa;
    }
</style>

<div class="card">
    <div class="card-body p-4 p-md-5">
        <div class="dog-icon-header">
            <i class="fas fa-paw fa-2x"></i>
        </div>

        <div class="text-center mb-4">
            <h2 class="fw-bold">Nuevo Compañero</h2>
            <p class="text-muted">Registra a tu perro para encontrarle su pareja ideal</p>
        </div>

        <form action="{{ route('perros.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fas fa-signature"></i> Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ej: Toby" required>
                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fas fa-dna"></i> Raza</label>
                    <input type="text" name="raza" class="form-control @error('raza') is-invalid @enderror" value="{{ old('raza') }}" placeholder="Ej: Golden Retriever" required>
                    @error('raza') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fas fa-birthday-cake"></i> Edad (años)</label>
                    <input type="number" name="edad" class="form-control @error('edad') is-invalid @enderror" value="{{ old('edad') }}" min="0" required>
                    @error('edad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fas fa-weight-hanging"></i> Peso (kg)</label>
                    <input type="number" step="0.1" name="peso" class="form-control @error('peso') is-invalid @enderror" value="{{ old('peso') }}" required>
                    @error('peso') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fas fa-venus-mars"></i> Sexo</label>
                    <select name="sexo" class="form-select @error('sexo') is-invalid @enderror" required>
                        <option value="">-- Selecciona --</option>
                        <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Macho</option>
                        <option value="H" {{ old('sexo') == 'H' ? 'selected' : '' }}>Hembra</option>
                    </select>
                    @error('sexo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label"><i class="fas fa-camera"></i> Foto del perro</label>
                    <input type="file" name="foto_url" class="form-control @error('foto_url') is-invalid @enderror" accept="image/*">
                    <small class="text-muted small">Sube una foto clara de tu mascota.</small>
                    @error('foto_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label"><i class="fas fa-info-circle"></i> Descripción</label>
                    <textarea name="descripción" class="form-control @error('descripción') is-invalid @enderror" rows="3" placeholder="¿Cómo es tu perro?">{{ old('descripción') }}</textarea>
                    @error('descripción') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-save shadow-sm">
                    <i class="fas fa-check-circle me-2"></i> Crear Perro
                </button>
                <div class="text-center mt-2">
                    <a href="{{ route('perros.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Cancelar y volver
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection