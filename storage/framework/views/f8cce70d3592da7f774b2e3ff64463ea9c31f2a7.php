<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    
</body>
<style>
    .navbar-bottom {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white; /* Color de fondo de la barra */
    border-top: 1px solid #ddd; /* Línea superior para distinguir la barra */
    z-index: 900; /* Asegura que esté por encima de otros elementos */
}
</style>

<nav class="navbar navbar-light bg-light navbar-bottom">
    <div class="container d-flex justify-content-around">
    
        <!-- Novedades -->
        <a href="<?php echo e(route('grupo.avisos', $grupo->id)); ?>" class="text-center text-decoration-none">
            <i class="bi bi-bell" style="font-size: 1.1rem;"></i>
            <div>Novedades</div>
        </a>
        <a href="<?php echo e(route('grupo.equipos', $grupo->id)); ?>" class="text-center text-decoration-none">
            <i class="bi bi-person-lines-fill" style="font-size: 1.1rem;"></i>
            <div>Equipos</div>
        </a>
        <!-- Tareas -->
        <a href="<?php echo e(route ('grupo.evaluaciones', $grupo->id)); ?>" class="text-center text-decoration-none">
            <i class="bi bi-list-check" style="font-size: 1.1rem;"></i>
            <div>Evaluaciones</div>
        </a>
        
    
        
    </div>
</nav>
</html><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/layouts/barraBaja.blade.php ENDPATH**/ ?>