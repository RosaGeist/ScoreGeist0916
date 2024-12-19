

<?php $__env->startSection('content'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/docente/dashboard">Página principal</a></li>
            <li class="breadcrumb-item"><a href="/grupos">Grupos</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('grupo.avisos', $grupo->id)); ?>"><?php echo e($grupo->nombre); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('grupo.equipos', $grupo->id)); ?>"> Equipos</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('proyecto.sprints', $proyecto->id)); ?>">
                    <?php echo e($proyecto->nombre); ?></a></li>
        </ol>
    </nav>
    <div class="container">
        <h1 class="d-flex justify-content-between align-items-center">
            Proyecto: <?php echo e($proyecto->nombre); ?>

            <a href="<?php echo e(route('reporte.proyecto', $proyecto->id)); ?>" class="btn btn-primary">
                <i class="bi bi-file-earmark-text"></i> Generar Reporte
            </a>
        </h1>

        <p><strong>Descripción:</strong> <?php echo e($proyecto->descripcion); ?></p>

        <h2>Sprints</h2>
        <?php if($proyecto->sprints->isNotEmpty()): ?>
            <div class="row">
                <?php $__currentLoopData = $proyecto->sprints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sprint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-12 col-lg-12 mx-auto mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                <h5><?php echo e($sprint->nombre); ?> (<?php echo e($sprint->estado); ?>)</h5>
                            </div>
                            <div class="card-body">
                                <!-- Información del sprint -->
                                <div class="d-flex justify-content-between">
                                    <div>

                                        <p><strong>Objetivo:</strong> <?php echo e($sprint->objetivo); ?></p>
                                    </div>
                                    <div>

                                        <p><strong>Duración:</strong> Inicio: <?php echo e($sprint->fecha_inicio); ?> - Fin:
                                            <?php echo e($sprint->fecha_fin); ?></p>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                  
                                    <div class="col-md-12">
                                        <h4 class="mb-4">Historias de Usuario:</h4>
                                        <?php if($sprint->historias->isNotEmpty()): ?>
                                            <?php $__currentLoopData = $sprint->historias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="card mb-4 shadow-sm border-0">
                                                    <!-- Card Header con fondo de color -->
                                                    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #007bff;">
                                                        <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>Historia de Usuario: <?php echo e($historia->titulo); ?></h5>
                                                        <span class="badge bg-light text-dark"><?php echo e($historia->estado); ?></span>
                                                    </div>
                                    
                                                    <!-- Card Body -->
                                                    <div class="card-body">
                                                        <p><strong><i class="bi bi-info-circle me-2"></i>Descripción:</strong> <?php echo e($historia->descripcion); ?></p>
                                                        <div class="d-flex justify-content-between mt-3">
                                                            <div><i class="bi bi-flag-fill text-danger me-2"></i><strong>Prioridad:</strong> <?php echo e($historia->prioridad); ?></div>
                                                        </div>
                                                        <h6 class="mt-4"><strong><i class="bi bi-check-circle-fill text-success me-2"></i>Criterios de Aceptación:</strong></h6>
                                                        <p><?php echo e($historia->criterios_aceptacion); ?></p>
                                                    </div>
                                    
                                                    <!-- Subtareas -->
                                                    <div class="card-footer bg-light">
                                                        <h6><i class="bi bi-list-task me-2"></i>Subtareas:</h6>
                                                        <?php if($historia->subtareas->isNotEmpty()): ?>
                                                            <?php $__currentLoopData = $historia->subtareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="card mb-3 border-0 shadow-sm">
                                                                    <div class="card-body">
                                                                        <strong><i class="bi bi-chevron-right"></i> <?php echo e($subtarea->titulo); ?>:</strong> <?php echo e($subtarea->descripcion); ?>

                                                                        <span class="badge bg-info ms-2"><?php echo e($subtarea->estado); ?></span>
                                                                        <?php if($subtarea->miembroAsignado): ?>
                                                                            <br><i class="bi bi-person-fill me-2"></i><strong>Asignado a:</strong> <?php echo e($subtarea->miembroAsignado->name); ?>

                                                                        <?php endif; ?>
                                                                    </div>
                                    
                                                                    <!-- Comentarios de Subtarea -->
                                                                    <div class="card-footer bg-white">
                                                                        <h6><i class="bi bi-chat-left-text-fill me-2"></i>Comentarios:</h6>
                                                                        <?php if($subtarea->comentarios->isNotEmpty()): ?>
                                                                            <?php $__currentLoopData = $subtarea->comentarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                                                    <p class="mb-0">
                                                                                        <strong><?php echo e($comentario->docente->name); ?></strong>: <?php echo e($comentario->contenido); ?>

                                                                                    </p>
                                                                                    <form action="<?php echo e(route('comentarios.subtarea.destroy', $comentario->id)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este comentario?')">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <?php echo method_field('DELETE'); ?>
                                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                                            <i class="bi bi-trash-fill"></i>
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php else: ?>
                                                                            <p>No hay comentarios para esta subtarea.</p>
                                                                        <?php endif; ?>
                                    
                                                                        <!-- Formulario para agregar comentario -->
                                                                        <div class="row mt-3">
                                                                            <form action="<?php echo e(route('comentarios.subtarea.store', $subtarea->id)); ?>" method="POST">
                                                                                <?php echo csrf_field(); ?>
                                                                                <div class="input-group">
                                                                                    <textarea class="form-control" name="contenido" rows="1" placeholder="Escribe tu comentario..."></textarea>
                                                                                    <button type="submit" class="btn btn-success">
                                                                                        <i class="bi bi-send-fill"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <p>No hay subtareas para esta historia.</p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                            <!-- Comentarios del Sprint -->
                                            <div class="card mt-4 shadow-sm border-0">
                                                <div class="card-header bg-secondary text-white">
                                                    <h5><i class="bi bi-chat-dots me-2"></i>Comentarios del Sprint</h5>
                                                </div>
                                                <div class="card-body">
                                                    <?php if($sprint->comentarios->isNotEmpty()): ?>
                                                        <?php $__currentLoopData = $sprint->comentarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                                <p class="mb-0"><strong><?php echo e($comentario->docente->name); ?></strong>: <?php echo e($comentario->contenido); ?></p>
                                                                <form action="<?php echo e(route('comentarios.sprint.destroy', $comentario->id)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este comentario?')">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <p>No hay comentarios para este sprint.</p>
                                                    <?php endif; ?>
                                    
                                                    <!-- Formulario para agregar comentario -->
                                                    <div class="row mt-3">
                                                        <form action="<?php echo e(route('comentarios.sprint.store', $sprint->id)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="input-group">
                                                                <textarea class="form-control" name="contenido" rows="1" placeholder="Escribe tu comentario..."></textarea>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="bi bi-send-fill"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <p>No hay historias de usuario para este sprint.</p>
                                        <?php endif; ?>
                                    </div>
                                    


                                </div>


                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p>No hay sprints registrados para este proyecto.</p>
        <?php endif; ?>
    </div>



    <?php echo $__env->make('layouts.barraBaja', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasDocentes/VistaGrupo/verSprints.blade.php ENDPATH**/ ?>