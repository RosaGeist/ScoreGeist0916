

<?php $__env->startSection('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
        <li class="breadcrumb-item"><?php echo e($equipo->nombre_empresa); ?></li>
        <li class="breadcrumb-item">Autoevaluaciones y por pares</li>
    </ol>
</nav>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Autoevaluación para el Sprint: <strong><?php echo e($sprint->nombre); ?></strong></h2>
            </div>
            <div class="card-body">
                
                <h3 class="text-secondary">Tus respuestas</h3>
                <form>
                    <?php echo csrf_field(); ?>
                    <?php $__currentLoopData = $preguntasAutoevaluacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pregunta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold"
                                for="pregunta_<?php echo e($pregunta->id); ?>"><?php echo e($pregunta->texto); ?></label>
                            <?php
                                $respuesta = $respuestasUsuario->where('pregunta_id', $pregunta->id)->first();
                            ?>
                            <input type="text" class="form-control" value="<?php echo e($respuesta->respuesta ?? 'No respondida'); ?>"
                                disabled>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </form>
            </div>
        </div>

        <?php if($equipo): ?>
            <div class="card shadow-lg mt-4">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Respuestas de tus compañeros de equipo</h3>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $respuestasMiembros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuarioId => $respuestas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $miembro = $equipo->miembros->where('id', $usuarioId)->first();
                        ?>
                        <div class="mb-4">
                            <h4 class="text-info">Evaluación de: <strong><?php echo e($miembro->name); ?></strong></h4>
                            <?php $__currentLoopData = $preguntasAutoevaluacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pregunta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-2">
                                    <label class="form-label"><?php echo e($pregunta->texto); ?></label>
                                    <?php
                                        $respuesta = $respuestas->where('pregunta_id', $pregunta->id)->first();
                                    ?>
                                    <input type="text" class="form-control"
                                        value="<?php echo e($respuesta->respuesta ?? 'No respondida'); ?>" disabled>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            
                            <?php if($miembro->id != auth()->id()): ?>
                                <!-- Solo mostrar el botón si no es el usuario autenticado -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalEvaluacion<?php echo e($miembro->id); ?>">
                                    Evaluar a <?php echo e($miembro->name); ?>

                                </button>
                            <?php endif; ?>
                            
                            <h3>Respuestas de Evaluación por Pares de tus Compañeros de Equipo</h3>

                            <?php $__currentLoopData = $respuestasEvaluacionPorParesMiembros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuarioId => $respuestas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            // Obtener la respuesta que contiene el usuario que evaluó
                            $respuesta = $respuestas->first();
                    
                            // Acceder al evaluador (usuario_id)
                            $evaluador = $respuesta->usuario; // Esto usará la relación 'usuario' definida en el modelo RespuestaPorPares
                        ?>
                    
                        <h4>Evaluado por: <?php echo e($evaluador->name); ?></h4> 
                                <?php $__currentLoopData = $preguntasPorPares; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pregunta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group">
                                        <label for="pregunta_<?php echo e($pregunta->id); ?>">
                                            <?php echo e($pregunta->texto); ?>

                                        </label>

                                        
                                        <?php
                                            $respuesta = $respuestas->where('pregunta_id', $pregunta->id)->first();
                                        ?>

                                        
                                        <input type="text" class="form-control"
                                            value="<?php echo e($respuesta->respuesta ?? 'No respondida'); ?>" disabled>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

                        
                        <div class="modal fade" id="modalEvaluacion<?php echo e($usuarioId); ?>" tabindex="-1"
                            aria-labelledby="modalLabel<?php echo e($usuarioId); ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalLabel<?php echo e($usuarioId); ?>">Evaluar a:
                                            <?php echo e($miembro->name); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo e(route('guardarEvaluacionPorPares', $sprint->id)); ?>"
                                            method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php $__currentLoopData = $preguntasPorPares; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pregunta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold"><?php echo e($pregunta->texto); ?></label>
                                                    <input type="number" class="form-control"
                                                        name="evaluaciones[<?php echo e($usuarioId); ?>][<?php echo e($pregunta->id); ?>]"
                                                        placeholder="Calificación (1-10)" required>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success">Guardar Evaluación</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning mt-4">No estás asignado a ningún equipo.</div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasEstudiantes/formulario.blade.php ENDPATH**/ ?>