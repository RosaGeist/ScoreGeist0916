

<?php $__env->startSection('content'); ?>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearPreguntaModal">
    <i class="bi bi-plus-circle"></i> Crear Nueva Pregunta
</button>

<!-- Modal para crear pregunta -->
<div class="modal fade" id="crearPreguntaModal" tabindex="-1" aria-labelledby="crearPreguntaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearPreguntaModalLabel">Nueva Pregunta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Incluyendo el formulario de creación -->
                <?php echo $__env->make('VistasDocentes.pregunta-form', [
                    'route' => route('preguntas.store'),
                    'method' => 'POST',
                    'buttonText' => 'Guardar Pregunta'
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>

<?php $__currentLoopData = ['autoevaluacion', 'cruzada', 'porpares']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evaluacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card mb-3">
        <div class="card-header bg-<?php echo e($loop->index === 0 ? 'primary' : ($loop->index === 1 ? 'success' : 'info')); ?> text-white">
            <i class="bi bi-check-circle"></i> Evaluación: <?php echo e(ucfirst($evaluacion)); ?>

        </div>
        <div class="card-body">
            <?php if(isset($preguntasAgrupadas[$evaluacion])): ?>
                <ul class="list-group">
                    <?php $__currentLoopData = $preguntasAgrupadas[$evaluacion]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pregunta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item">
                            <strong><?php echo e($pregunta->texto); ?></strong><br>
                            <span><i class="bi bi-question-square"></i></i> Tipo: <?php echo e(ucfirst(str_replace('_', ' ', $pregunta->tipo))); ?></span><br>
                            <span><i class="bi bi-check-circle"></i> Estado: <?php echo e($pregunta->estado); ?></span>
                            <form action="<?php echo e(route('preguntas.destroy', $pregunta->id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</button>
                            </form>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarPregunta<?php echo e($pregunta->id); ?>"><i class="bi bi-pencil"></i> Editar</button>
                        </li>
                        <!-- Modal para editar pregunta -->
                        <div class="modal fade" id="editarPregunta<?php echo e($pregunta->id); ?>" tabindex="-1" aria-labelledby="editarPregunta<?php echo e($pregunta->id); ?>Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editarPregunta<?php echo e($pregunta->id); ?>Label">Editar Pregunta</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Incluyendo el formulario de edición -->
                                        <?php echo $__env->make('VistasDocentes.pregunta-form', [
                                            'route' => route('preguntas.update', $pregunta->id),
                                            'method' => 'PUT',
                                            'buttonText' => 'Guardar Cambios'
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <p><i class="bi bi-exclamation-triangle"></i> No hay preguntas de <?php echo e($evaluacion); ?> aún.</p>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasDocentes/preguntas.blade.php ENDPATH**/ ?>