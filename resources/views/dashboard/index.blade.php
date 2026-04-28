@extends('layouts.app')

@section('content')


<div class="dashboard-header text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-2"><p>Bienvenido, {{ session('usuario')->nombre }}</p> 🐾</h1>
        <p class="opacity-75 fs-5">Panel de control de PetMatch</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card stat-card shadow-sm h-100 p-4">
                <div class="icon-box bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-dog fa-2x"></i>
                </div>
                <h4 class="fw-bold">Mis Perros</h4>
                <p class="text-muted">Gestiona tus mascotas registradas.</p>
                <div class="mt-auto">
                    <a href="{{ route('perros.index') }}" class="btn btn-primary btn-action w-100">Administrar</a>
                </div>
            </div>
        </div>

        <div class="row mt-4">
        <div class="col-12">
            <div class="card stat-card shadow-sm p-4 border-0" style="background: linear-gradient(to right, #ffffff, #f8f9ff);">
                <div class="d-flex align-items-center flex-wrap flex-md-nowrap">
                    <div class="icon-box bg-info bg-opacity-10 text-info me-4 mb-0">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 mt-3 mt-md-0">
                        <h4 class="fw-bold mb-1">Mi Perfil</h4>
                        <p class="text-muted mb-0">Gestiona tu información personal, ciudad y contacto.</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('perfil.edit') }}" class="btn btn-outline-info btn-action px-4">
                            <i class="fas fa-edit me-2"></i> Editar Perfil
                        </a>
                    </div>
                </div>
                
                <hr class="my-4 opacity-50">
                
                <div class="row text-center text-md-start">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <span class="text-muted small text-uppercase fw-bold">Email</span>
                        <p class="mb-0 fw-bold text-dark">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <span class="text-muted small text-uppercase fw-bold">Teléfono</span>
                        <p class="mb-0 fw-bold text-dark">{{ auth()->user()->teléfono ?? 'No asignado' }}</p>
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted small text-uppercase fw-bold">Ubicación</span>
                        <p class="mb-0 fw-bold text-dark"><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ auth()->user()->ciudad ?? 'No asignada' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="col-md-4">
            <div class="card stat-card shadow-sm h-100 p-4">
                <div class="icon-box bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-search fa-2x"></i>
                </div>
                <h4 class="fw-bold">Explorar</h4>
                <p class="text-muted">Busca otros perros para hacer match.</p>
                <div class="mt-auto">
                    <a href="{{ route('busqueda.index') }}" class="btn btn-warning btn-action w-100 text-white">Buscar Pareja</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card shadow-sm h-100 p-4">
                <div class="icon-box bg-success bg-opacity-10 text-success">
                    <i class="fas fa-comments fa-2x"></i>
                </div>
                <h4 class="fw-bold">Mensajes</h4>
                <p class="text-muted">Conversaciones con otros dueños.</p>
                <div class="mt-auto">
                    <a href="{{ route('mensajes.index') }}" class="btn btn-success btn-action w-100">Abrir Chats</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="p-4 bg-white shadow-sm" style="border-radius: 30px;">
                <h5 class="text-center text-muted small fw-bold text-uppercase mb-4" style="letter-spacing: 2px;">Acciones Rápidas</h5>
                <div class="d-flex flex-wrap justify-content-center gap-4">
                    
                    <a href="{{ route('perros.create') }}" class="btn-quick-action">
                        <div class="icon-circle bg-primary text-white">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span>Nuevo Perro</span>
                    </a>

                    <a href="{{ route('matching.listado') }}" class="btn-quick-action">
                        <div class="icon-circle bg-danger text-white">
                            <i class="fas fa-heart"></i>
                        </div>
                        <span>Mis Matches</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-quick-action border-0 bg-transparent" style="cursor: pointer;">
                            <div class="icon-circle bg-dark text-white">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <span>Salir</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection