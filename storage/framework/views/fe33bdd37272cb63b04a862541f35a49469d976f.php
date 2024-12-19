

<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/docente/dashboard">Página principal</a></li>
        <li class="breadcrumb-item"><a href="/grupos">Grupos</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('grupo.avisos', $grupo->id)); ?>"><?php echo e($grupo->nombre); ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('grupo.equipos', $grupo->id)); ?>"> Equipos</a></li>
    </ol>
</nav>
<h1>Equipos</h1>

<?php $__currentLoopData = $grupo->equipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <h3>Equipo: <?php echo e($equipo->nombre_empresa); ?></h3>

    <h4>Miembros:</h4>
    <ul>
        <?php $__currentLoopData = $equipo->miembros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miembro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($miembro->name); ?> (<?php echo e($miembro->email); ?>)</li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <h4>Proyectos:</h4>
    <?php if($equipo->proyectos->isNotEmpty()): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Objetivos</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
               
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $equipo->proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><a href="<?php echo e(route('proyecto.sprints', $proyecto->id)); ?>">
                            <?php echo e($proyecto->nombre); ?>

                        </a></td>
                        <td><?php echo e($proyecto->descripcion); ?></td>
                        <td><?php echo e($proyecto->objetivos); ?></td>
                        <td><?php echo e($proyecto->duracion_inicio); ?></td>
                        <td><?php echo e($proyecto->duracion_fin); ?></td>
                        <td><?php echo e($proyecto->estado); ?></td>
                        
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay proyectos registrados para este equipo.</p>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php echo $__env->make('layouts.barraBaja', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasDocentes/VistaGrupo/listaEquipos.blade.php ENDPATH**/ ?>