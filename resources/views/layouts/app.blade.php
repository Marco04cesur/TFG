<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TFG Perros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Esto asegura que el fondo siempre cubra toda la pantalla */
        html, body {
            height: 100%;
            margin: 0;
        }
        main {
            min-height: 100%;
        }
    </style>
</head>
<body>
    <!--  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">DogMatch</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('perros.index') }}">Mis Perros</a>
                <a class="nav-link" href="{{ route('matching.show') }}">Matching</a>
            </div>
        </div>
    </nav> -->

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>