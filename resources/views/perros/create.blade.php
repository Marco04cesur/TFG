@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- Botón de Volver (Minimalista) -->
            <div class="mb-4">
                <a href="{{ route('perros.index') }}" class="text-decoration-none fw-bold" style="color: var(--sea-green); transition: color 0.3s;">
                    <i class="fas fa-arrow-left me-2"></i> Volver a Mis Perros
                </a>
            </div>

            <!-- Tarjeta Principal -->
            <div class="stat-card p-4 p-md-5 border-0">
                
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-sm" style="width: 70px; height: 70px; background-color: var(--bg-secondary);">
                        <i class="fas fa-paw fa-2x" style="color: var(--tiger-orange);"></i>
                    </div>
                    <h2 class="fw-bold mb-1" style="color: var(--deep-forest); letter-spacing: -1px;">Nuevo Compañero</h2>
                    <p class="text-muted" style="font-weight: 500;">Registra a tu perro para encontrarle su pareja ideal </p>
                </div>

                <form action="{{ route('perros.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4 mb-5">
                        
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;"><i class="fas fa-signature me-1"></i> Nombre</label>
                            <input type="text" name="nombre" class="form-control p-3 @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ej: Toby" required style="border-radius: 12px;">
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Raza -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;"><i class="fas fa-dna me-1"></i> Raza</label>
                            <input type="text" name="raza" class="form-control p-3 @error('raza') is-invalid @enderror" value="{{ old('raza') }}" placeholder="Ej: Golden Retriever" required style="border-radius: 12px;">
                            @error('raza') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Edad -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;"><i class="fas fa-birthday-cake me-1"></i> Edad (años)</label>
                            <input type="number" name="edad" class="form-control p-3 @error('edad') is-invalid @enderror" value="{{ old('edad') }}" min="0" required style="border-radius: 12px;">
                            @error('edad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Peso -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;"><i class="fas fa-weight-hanging me-1"></i> Peso (kg)</label>
                            <input type="number" step="0.1" name="peso" class="form-control p-3 @error('peso') is-invalid @enderror" value="{{ old('peso') }}" required style="border-radius: 12px;">
                            @error('peso') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Sexo -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;"><i class="fas fa-venus-mars me-1"></i> Sexo</label>
                            <select name="sexo" class="form-select p-3 @error('sexo') is-invalid @enderror" required style="border-radius: 12px; cursor: pointer;">
                                <option value="" disabled selected>-- Selecciona --</option>
                                <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Macho</option>
                                <option value="H" {{ old('sexo') == 'H' ? 'selected' : '' }}>Hembra</option>
                            </select>
                            @error('sexo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Foto -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;"><i class="fas fa-camera me-1"></i> Foto del perro</label>
                            <input type="file" name="foto_url" class="form-control p-3 @error('foto_url') is-invalid @enderror" accept="image/*" style="border-radius: 12px;">
                            <small class="text-muted small mt-1 d-block">Sube una foto clara de tu mascota (Recomendado: formato cuadrado, JPG o PNG).</small>
                            @error('foto_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;"><i class="fas fa-info-circle me-1"></i> Descripción</label>
                            <textarea name="descripción" class="form-control p-3 @error('descripción') is-invalid @enderror" rows="4" placeholder="Cuéntanos un poco sobre su personalidad, gustos o lo que buscas en un match..." style="border-radius: 12px; resize: none;">{{ old('descripción') }}</textarea>
                            @error('descripción') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="text-end border-top pt-4" style="border-color: rgba(0, 129, 72, 0.1) !important;">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm w-100 mb-3" style="font-size: 1.1rem;">
                            <i class="fas fa-check-circle me-2"></i> Registrar Perro
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ route('perros.index') }}" class="text-decoration-none fw-bold" style="color: var(--pure-red); font-size: 0.9rem;">
                                Cancelar
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection