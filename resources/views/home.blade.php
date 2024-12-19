<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}"> <!-- Asegúrate de que esta ruta sea correcta -->
</head>
<body>
    <header>
        <img src="tu_logo.png" alt="Logo"> <!-- Cambia esta ruta por la de tu logo -->
        <a href="#" class="header-link">Inicio</a>
        <a href="#" class="header-link">Sobre Nosotros</a>
        <a href="#" class="header-link">Contacto</a>
    </header>

    <div class="container mt-5">
        <h1>Bienvenido, has iniciado sesión correctamente.</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Tu Empresa. Todos los derechos reservados.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
