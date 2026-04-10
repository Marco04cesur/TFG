@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f7f6;
    }
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 0; /* Un poco más de aire */
        border-radius: 0 0 40px 40px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(118, 75, 162, 0.3);
    }
    .stat-card {
        border: none;
        border-radius: 25px;
        transition: all 0.3s ease;
        background: white;
    }
    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    .icon-box {
        width: 65px;
        height: 65px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .btn-action {
        border-radius: 50px; /* Estilo pill como el login */
        padding: 12px 25px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }
    .btn-quick-action {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #444;
            font-weight: bold;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-quick-action .icon-circle {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .btn-quick-action:hover {
            color: #000;
            transform: translateY(-5px);
        }

        .btn-quick-action:hover .icon-circle {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        /* Colores específicos al pasar el ratón */
        .btn-quick-action:hover span {
            text-decoration: underline;
        }
</style>

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