@extends('layouts.app')

@section('content')


<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 d-flex align-items-center gap-4">
                <div class="shadow-sm" style="background-color: white; padding: 12px; border-radius: 20px;">
                    <img src="{{ asset('images/petmatch_logo_modoclaro.png') }}" alt="PetMatch Logo" style="height: 70px; width: auto; display: block;">
                </div>
                
                <div>
                    <h1 class="mb-1" style="font-weight: 800; letter-spacing: -1px;">Hola!!, {{ session('usuario')->nombre ?? auth()->user()->nombre }}</h1>
                    <p class="mb-0 fs-5" style="color: var(--sea-green); font-weight: 500;">Panel de control</p>
                </div>
            </div>
            
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <a href="{{ route('perfil.edit') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold" style="border-width: 2px;">
                    Editar Perfil
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: -45px; position: relative; z-index: 10;">
    <div class="stat-card p-4 shadow-lg d-flex justify-content-between flex-wrap gap-3" style="border-radius: 20px; border: none;">
        
        <div class="flex-grow-1 px-3">
            <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 1.5px;">Email</span>
            <p class="mb-0 fs-5" style="color: var(--deep-forest); font-weight: 600;">{{ auth()->user()->email }}</p>
        </div>
        
        <div class="d-none d-md-block" style="width: 1px; background-color: var(--sea-green); opacity: 0.2;"></div>
        
        <div class="flex-grow-1 px-3">
            <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 1.5px;">Teléfono</span>
            <p class="mb-0 fs-5" style="color: var(--deep-forest); font-weight: 600;">{{ auth()->user()->teléfono ?? '--' }}</p>
        </div>
        
        <div class="d-none d-md-block" style="width: 1px; background-color: var(--sea-green); opacity: 0.2;"></div>
        
        <div class="flex-grow-1 px-3">
            <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 1.5px;">Ubicación</span>
            <p class="mb-0 fs-5" style="color: var(--deep-forest); font-weight: 600;">{{ auth()->user()->ciudad ?? '--' }}</p>
        </div>

    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="stat-card h-100 p-4 p-lg-5 d-flex flex-column justify-content-between text-start" style="border-radius: 20px;">
                <div>
                    <span class="small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;">Gestión</span>
                    <h3 class="mt-2 mb-3" style="color: var(--deep-forest); font-weight: 800; letter-spacing: -0.5px;">Mis Perros</h3>
                    <p class="text-muted" style="font-size: 0.95rem;">Administra la información, fotos y datos de tus mascotas registradas en la plataforma.</p>
                </div>
                <a href="{{ route('perros.index') }}" class="btn btn-primary w-100 rounded-pill fw-bold mt-4 py-2">
                    Administrar &rarr;
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card h-100 p-4 p-lg-5 d-flex flex-column justify-content-between text-start" style="border-radius: 20px; border: 2px solid var(--golden-glow); background-color: #fcfcf9;">
                <div>
                    <span class="small fw-bold text-uppercase" style="color: var(--tiger-orange); letter-spacing: 1px;">Descubrir</span>
                    <h3 class="mt-2 mb-3" style="color: var(--deep-forest); font-weight: 800; letter-spacing: -0.5px;">Explorar</h3>
                    <p class="text-muted" style="font-size: 0.95rem;">Busca y filtra perfiles de otros perros para encontrar la pareja ideal.</p>
                </div>
                <a href="{{ route('busqueda.index') }}" class="btn btn-accent w-100 rounded-pill fw-bold mt-4 py-2">
                    Buscar Pareja &rarr;
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card h-100 p-4 p-lg-5 d-flex flex-column justify-content-between text-start" style="border-radius: 20px;">
                <div>
                    <span class="small fw-bold text-uppercase" style="color: var(--sea-green); letter-spacing: 1px;">Comunicación</span>
                    <h3 class="mt-2 mb-3" style="color: var(--deep-forest); font-weight: 800; letter-spacing: -0.5px;">Mensajes</h3>
                    <p class="text-muted" style="font-size: 0.95rem;">Revisa tus conversaciones activas y conecta con otros dueños y criadores.</p>
                </div>
                <a href="{{ route('mensajes.index') }}" class="btn btn-primary w-100 rounded-pill fw-bold mt-4 py-2" style="border-color: var(--deep-forest); color: var(--deep-forest);">
                    Abrir Chats &rarr;
                </a>
            </div>
        </div>

    </div>

    <div class="row mt-5 pt-4">
        <div class="col-12 text-center">
            <div class="d-flex flex-wrap justify-content-center gap-4">
                
            
                
                <a href="{{ route('matching.listado') }}" class="text-decoration-none fw-bold" style="color: var(--deep-forest);">
                    Ver mis Matches
                </a>
                
                <span class="text-muted">|</span>
                
                <form action="{{ route('logout') }}" method="POST" class="d-inline m-0 p-0">
                    @csrf
                    <button type="submit" class="border-0 bg-transparent text-decoration-none fw-bold p-0" style="color: var(--pure-red);">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection