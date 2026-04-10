@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>Editar mi Perfil</h2>
        <p>Aquí irá el formulario para editar a {{ $user->name }}</p>
    </div>
</div>
@endsection