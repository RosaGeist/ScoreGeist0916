<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreGeist - Gestión de Proyectos Educativos</title>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
</head>
<body>
    <header>
        <img src="path-to-your-logo.png" alt="ScoreGeist Logo">
        <a href="{{ route('login.form') }}" class="header-link">Iniciar Sesión</a>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Transforma la Gestión Educativa</h1>
            <p class="hero-description">ScoreGeist es la plataforma líder en gestión de proyectos y evaluación continua para estudiantes y docentes.</p>
            <a href="{{ route('login.form') }}" class="cta-button">Comenzar Ahora</a>
        </div>
    </section>

    <section class="features-section">
        <div class="features-grid">
            <div class="feature-card">
                <h3>Gestión de Proyectos</h3>
                <p>Organiza y gestiona proyectos educativos de manera eficiente con herramientas intuitivas.</p>
            </div>
            <div class="feature-card">
                <h3>Evaluación Continua</h3>
                <p>Realiza un seguimiento del progreso de los estudiantes con evaluaciones personalizadas.</p>
            </div>
            <div class="feature-card">
                <h3>Colaboración</h3>
                <p>Facilita la comunicación entre estudiantes y docentes en un entorno seguro.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 ScoreGeist. Todos los derechos reservados.</p>
    </footer>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

</body>
</html>