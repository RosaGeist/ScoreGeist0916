<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}"> <!-- Asegúrate de que la ruta sea correcta -->
    <style>
        body {
            background-color: var(--background-color);
        }
        .card {
            border: none;
            box-shadow: var(--shadow);
            margin-top: 20px; /* Añadir margen superior para separación */
        }
        .card-title {
            color: var(--text-color); /* Utilizar la variable para el color del título */
        }
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
        }
        .btn-primary:hover {
            background-color: #4BBEBD; /* Color más oscuro al pasar el ratón */
        }
        .alert {
            background-color: #FFEBEE; /* Color de fondo de la alerta */
            color: #D32F2F; /* Color de texto de la alerta */
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center">Iniciar Sesión</h5>
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input id="email" class="form-control" type="email" name="email" required autofocus aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" class="form-control" type="password" name="password" required aria-describedby="passwordHelp">
                    </div>
                    <div class="m-3 text-center">
                    
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('password.request') }}" class="link-secondary">¿Olvidaste tu contraseña?</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>  