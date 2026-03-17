<!DOCTYPE html>
<html>
<head>
    <title>Registro - PetMatch</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 500px; margin: 50px auto; }
        .card { background: white; padding: 30px; border-radius: 10px; 
                box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #004E89; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #333; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; 
                border-radius: 5px; }
        button { width: 100%; padding: 10px; background: #FF6B35; 
                 color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #E55A25; }
        .error { color: red; font-size: 0.9em; }
        .link { text-align: center; margin-top: 15px; }
        .link a { color: #FF6B35; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>🐕 PetMatch - Crear Cuenta</h2>
            
            @if ($errors->any())
                <div class="error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf
                <div class="form-group">
                    <label>Nombre Completo:</label>
                    <input type="text" name="nombre" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Teléfono (opcional):</label>
                    <input type="tel" name="teléfono">
                </div>
                <div class="form-group">
                    <label>Ciudad (opcional):</label>
                    <input type="text" name="ciudad">
                </div>
                <div class="form-group">
                    <label>Contraseña:</label>
                    <input type="password" name="contraseña" required>
                </div>
                <div class="form-group">
                    <label>Confirmar Contraseña:</label>
                    <input type="password" name="contraseña_confirmation" required>
                </div>
                <button type="submit">Crear Cuenta</button>
            </form>

            <div class="link">
                ¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a>
            </div>
        </div>
    </div>
</body>
</html>
