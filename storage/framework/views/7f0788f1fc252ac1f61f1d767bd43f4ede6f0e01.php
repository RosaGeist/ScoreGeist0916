

<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/docente/dashboard">Página principal</a></li>
        <li class="breadcrumb-item"><a href="/grupos">Grupos</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('grupo.avisos', $grupo->id)); ?>"><?php echo e($grupo->nombre); ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('grupo.avisos', $grupo->id)); ?>"> Novedades</a></li>
    </ol>
</nav>
<div class="container">
    <h1>Novedades de <?php echo e($grupo->nombre); ?></h1>
    <ul class="list-group">
        <?php $__empty_1 = true; $__currentLoopData = $grupo->avisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aviso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li class="list-group-item"><?php echo e($aviso->titulo); ?> - <?php echo e($aviso->contenido); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="list-group-item">No hay novedades.</li>
        <?php endif; ?>
    </ul>
</div>
<?php echo $__env->make('layouts.barraBaja', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasDocentes/VistaGrupo/avisos.blade.php ENDPATH**/ ?>