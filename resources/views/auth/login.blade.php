@extends('layouts.app')



@section('content')

<style>

    body {

        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;

        min-height: 100vh;

        display: flex;

        align-items: center;

        justify-content: center;

        margin: 0;

        padding: 15px;

        /* Animación de entrada */

        animation: fadeIn 0.8s ease-out;

    }



    @keyframes fadeIn {

        from { opacity: 0; transform: translateY(20px); }

        to { opacity: 1; transform: translateY(0); }

    }



    .card {

        border-radius: 25px;

        border: none;

        /* Sombra profunda para el efecto de salto */

        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;

        transition: transform 0.3s ease;

        padding: 60px;

        width: 100%;

        /* ANCHO AMPLIADO */

        max-width: 550px;

    }



    .card:hover {

        transform: translateY(-5px);

    }



    .dog-icon {

        width: 85px;

        height: 85px;

        background: #ffffff;

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        margin: -75px auto 20px;

        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);

        color: #764ba2;

        border: 5px solid #ffffff;

    }



    .form-control {

        border-radius: 12px;

        padding: 15px;

        background-color: #f8f9fa;

        border: 2px solid #f8f9fa;

        transition: all 0.3s;

    }



    .form-control:focus {

        background-color: #fff;

        border-color: #e0e6ed;

        box-shadow: none;

    }



    .btn-primary {

        background: #764ba2;

        border: none;

        padding: 15px;

        font-weight: bold;

        border-radius: 50px;

        font-size: 1.1rem;

        text-transform: uppercase;

        letter-spacing: 1px;

    }



    .btn-primary:hover {

        background: #5a397a;

        transform: scale(1.02);

    }

</style>



<div class="container d-flex justify-content-center">

    <div class="card">

        <div class="card-body p-4 p-md-5">

            <div class="dog-icon">

                <i class="fas fa-dog fa-2x"></i>

            </div>



            <h2 class="text-center fw-bold mb-1" style="color: #333;">¡Hola de nuevo!</h2>

            <p class="text-center text-muted mb-4">Inicia sesión en PetMatch para continuar</p>



            @if ($errors->any())

                <div class="alert alert-danger py-2 px-3 small rounded-3 mb-4">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif



            <form method="POST" action="/login">

                @csrf



                <div class="mb-3">

                    <label class="form-label small fw-bold text-muted text-uppercase">Email</label>

                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="correo@ejemplo.com">

                </div>



                <div class="mb-4">

                    <label class="form-label small fw-bold text-muted text-uppercase">Contraseña</label>

                    <input type="password" name="password" class="form-control" required placeholder="********">

                </div>



                <div class="d-grid">

                    <button type="submit" class="btn btn-primary shadow-sm">Entrar</button>

                </div>

            </form>



            <div class="text-center mt-4 pt-3 border-top">

                <p class="small text-muted mb-0">¿No tienes cuenta?

                    <a href="/register" class="text-decoration-none text-primary fw-bold">Regístrate aquí</a>

                </p>

            </div>

        </div>

    </div>

</div>

@endsection