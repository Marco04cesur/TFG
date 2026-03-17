<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - PetMatch</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f5f5f5; }
        .header { background: linear-gradient(135deg, #667eea, #764ba2); 
                  color: white; padding: 20px; }
        .container { max-width: 1000px; margin: 20px auto; }
        .nav { display: flex; gap: 10px; margin-bottom: 20px; }
        .nav a { background: white; padding: 10px 20px; text-decoration: none; 
                 color: #004E89; border-radius: 5px; }
        .nav a:hover { background: #f0f0f0; }
        .welcome { background: white; padding: 20px; border-radius: 10px; 
                   box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #004E89; margin-bottom: 10px; }
        p { color: #666; margin-bottom: 10px; }
        button { background: #FF6B35; color: white; padding: 10px 20px; 
                 border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>🐕 PetMatch</h1>
            <p>Bienvenido, {{ session('usuario')->nombre }}</p>
        </div>
    </div>

    <div class="container">
        <div class="nav">
            <a href="/perfil">Mi Perfil</a>
            <a href="/perros">Mis Perros</a>
            <a href="/buscar">Buscar Parejas</a>
            <a href="/matches">Mis Matches</a>
            <a href="/mensajes">Mensajes</a>
            <form method="POST" action="/logout" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>

        <div class="welcome">
            <h2>¡Bienvenido a PetMatch!</h2>
            <p>Hola {{ session('usuario')->nombre }}, estás listo para encontrar 
               la pareja perfecta para tu perro.</p>
            <p><strong>Próximos pasos:</strong></p>
            <ul style="margin-left: 20px;">
                <li>Completa tu perfil</li>
                <li>Registra tu perro</li>
                <li>Busca parejas compatibles</li>
                <li>¡Haz matching!</li>
            </ul>
        </div>
    </div>
</body>
</html>
