<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreGeist - Gestión de Proyectos Educativos</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/menu.css')); ?>">
</head>
<body>
    <header>
        <img src="path-to-your-logo.png" alt="ScoreGeist Logo">
        <a href="<?php echo e(route('login.form')); ?>" class="header-link">Iniciar Sesión</a>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Transforma la Gestión Educativa</h1>
            <p class="hero-description">ScoreGeist es la plataforma líder en gestión de proyectos y evaluación continua para estudiantes y docentes.</p>
            <a href="<?php echo e(route('login.form')); ?>" class="cta-button">Comenzar Ahora</a>
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
    <?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

</body>
</html><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/principal.blade.php ENDPATH**/ ?>