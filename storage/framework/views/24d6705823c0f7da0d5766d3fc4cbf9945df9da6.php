

<?php $__env->startSection('content'); ?>



    <div class="container">
        <h1>Evaluaciones del Grupo: <?php echo e($grupo->nombre); ?></h1>

        <h2>Autoevaluaciones</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $respuestasAutoevaluacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respuesta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($respuesta->usuario->name); ?></td>
                        <td><?php echo e($respuesta->pregunta->texto); ?></td>
                        <td><?php echo e($respuesta->respuesta); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <h2>Evaluaciones Cruzadas</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Evaluador</th>
                    <th>Evaluado</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $respuestasCruzadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respuesta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($respuesta->usuario->name); ?></td>
                        <td><?php echo e($respuesta->evaluado->name); ?></td>
                        <td><?php echo e($respuesta->pregunta->texto); ?></td>
                        <td><?php echo e($respuesta->respuesta); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>


<?php echo $__env->make('layouts.barraBaja', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasDocentes/VistaGrupo/evaluaciones.blade.php ENDPATH**/ ?>