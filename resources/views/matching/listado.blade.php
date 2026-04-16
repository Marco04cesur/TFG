@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f7f6; }

    .page-header {
        background: linear-gradient(135deg, #FF6B35 0%, #F9A03F 100%);
        padding: 40px 0;
        border-radius: 0 0 30px 30px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
    }

    /* Estilo de las pestañas */
    .nav-pills-custom .nav-link {
        color: #6c757d;
        background-color: white;
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: bold;
        margin: 0 5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }

    .nav-pills-custom .nav-link.active {
        background-color: #764ba2;
        color: white;
        box-shadow: 0 8px 20px rgba(118, 75, 162, 0.3);
    }

    /* Tarjetas de Match */
    .match-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        background: white;
        overflow: hidden;
    }

    .match-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.1);
    }

    /* Fotos conectadas */
    .duo-images {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 0;
        background: #f8f9fa;
        position: relative;
    }

    .duo-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 2;
    }

    .duo-img.left { margin-right: -15px; }
    .duo-img.right { margin-left: -15px; }

    .heart-center {
        position: absolute;
        z-index: 3;
        background: white;
        border-radius: 50%;
        padding: 8px;
        color: #FF6B35;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        font-size: 1.2rem;
    }

    .btn-action-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        font-size: 1.2rem;
    }
</style>

<div class="page-header text-center">
    <div class="container relative">
        <div style="position: absolute; top: 0; left: 15px;">
            <a href="{{ url('/dashboard') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm text-dark">
                <i class="fas fa-arrow-left me-2"></i> Dashboard
            </a>
        </div>
        <h1 class="display-5 fw-bold mb-0"><i class="fas fa-heart me-2"></i> Mis Matches</h1>
        <p class="fs-5 opacity-75 mt-2">Gestiona las conexiones de tus peludos</p>
    </div>
</div>

<div class="container mb-5">

    @if(session('success'))
        <div class="alert alert-success rounded-pill fw-bold text-center border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <ul class="nav nav-pills nav-pills-custom justify-content-center mb-5" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-recibidas-tab" data-bs-toggle="pill" data-bs-target="#pills-recibidas" type="button" role="tab">
                Nuevas Solicitudes <span class="badge bg-danger ms-1">{{ $recibidas->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-aceptados-tab" data-bs-toggle="pill" data-bs-target="#pills-aceptados" type="button" role="tab">
                Matches Aceptados <span class="badge bg-success ms-1">{{ $aceptados->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-enviadas-tab" data-bs-toggle="pill" data-bs-target="#pills-enviadas" type="button" role="tab">
                Enviadas <span class="badge bg-secondary ms-1">{{ $enviadas->count() }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        
        <div class="tab-pane fade show active" id="pills-recibidas" role="tabpanel">
            <div class="row g-4">
                @forelse($recibidas as $match)
                    <div class="col-md-6 col-lg-4">
                        <div class="card match-card h-100 text-center d-flex flex-column">
                            <div class="duo-images">
                                <a href="{{ route('perros.show', $match->perro1) }}" title="Ver perfil de {{ $match->perro1->nombre }}">
                                    <img src="{{ $match->perro1->foto_url ? asset('storage/'.$match->perro1->foto_url) : asset('images/default-dog.png') }}" class="duo-img left" alt="Otro perro" style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                </a>
                                <i class="fas fa-heart heart-center"></i>
                                <img src="{{ $match->perro2->foto_url ? asset('storage/'.$match->perro2->foto_url) : asset('images/default-dog.png') }}" class="duo-img right" alt="Mi perro">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="fw-bold mb-1">
                                    ¡<a href="{{ route('perros.show', $match->perro1) }}" class="text-dark text-decoration-none" style="border-bottom: 2px dotted #FF6B35;">{{ $match->perro1->nombre }}</a> quiere conocer a {{ $match->perro2->nombre }}!
                                </h5>
                                <p class="text-muted small mb-3">De la ciudad de {{ $match->perro1->usuario->ciudad ?? 'Desconocida' }}</p>
                                
                                <div class="mb-4">
                                    <a href="{{ route('perros.show', $match->perro1) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold">
                                        <i class="fas fa-search-plus me-1"></i> Inspeccionar Perfil
                                    </a>
                                </div>
                                
                                <div class="d-flex justify-content-center gap-3 mt-auto">
                                    <form action="{{ route('matching.rechazar', $match) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action-circle bg-danger bg-opacity-10 text-danger shadow-sm" title="Rechazar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('matching.aceptar', $match) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action-circle bg-success text-white shadow-sm" style="transform: scale(1.1);" title="Aceptar Match">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3"></i>
                        <h4 class="text-muted">No tienes solicitudes nuevas</h4>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="pills-aceptados" role="tabpanel">
            <div class="row g-4">
                @forelse($aceptados as $match)
                    @php
                        // Determinamos cuál es mi perro y cuál es el del otro usuario
                        $miPerro = $misPerrosIds->contains($match->perro_id_1) ? $match->perro1 : $match->perro2;
                        $otroPerro = $misPerrosIds->contains($match->perro_id_1) ? $match->perro2 : $match->perro1;
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card match-card h-100 text-center border-success border-bottom border-3">
                            <div class="duo-images bg-success bg-opacity-10">
                                <img src="{{ $miPerro->foto_url ? asset('storage/'.$miPerro->foto_url) : asset('images/default-dog.png') }}" class="duo-img left">
                                <i class="fas fa-check-circle heart-center text-success"></i>
                                <img src="{{ $otroPerro->foto_url ? asset('storage/'.$otroPerro->foto_url) : asset('images/default-dog.png') }}" class="duo-img right">
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold mb-1">¡Es un Match Oficial!</h5>
                                <p class="text-muted small mb-4">{{ $miPerro->nombre }} y {{ $otroPerro->nombre }}</p>
                                
                                <a href="#" class="btn btn-success rounded-pill px-4 fw-bold">
                                    <i class="fas fa-comment-dots me-2"></i> Enviar Mensaje
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">Aún no tienes matches aceptados.</h4>
                        <a href="{{ route('busqueda.index') }}" class="btn btn-primary rounded-pill mt-3 px-4">¡Ir a buscar!</a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="pills-enviadas" role="tabpanel">
            <div class="row g-4">
                @forelse($enviadas as $match)
                    <div class="col-md-6 col-lg-4">
                        <div class="card match-card h-100 text-center opacity-75">
                            <div class="duo-images">
                                <img src="{{ $match->perro1->foto_url ? asset('storage/'.$match->perro1->foto_url) : asset('images/default-dog.png') }}" class="duo-img left">
                                <i class="fas fa-hourglass-half heart-center text-secondary"></i>
                                <img src="{{ $match->perro2->foto_url ? asset('storage/'.$match->perro2->foto_url) : asset('images/default-dog.png') }}" class="duo-img right">
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold mb-1">Esperando respuesta...</h5>
                                <p class="text-muted small mb-0">Le enviaste un like a {{ $match->perro2->nombre }} con {{ $match->perro1->nombre }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">No has enviado ninguna solicitud recientemente.</h4>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection