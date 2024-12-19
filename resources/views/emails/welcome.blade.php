<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido a nuestra plataforma</title>
</head>
<body>
    <h1>¡Bienvenido, {{ $user->name }}!</h1>
    <p>Tu cuenta ha sido activada con éxito.</p>
    <p>Haz clic en el siguiente enlace para iniciar sesión:</p>
    <a href="{{ url('/login') }}">Iniciar sesión</a>
</body>
</html>

