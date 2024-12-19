

<?php $__env->startSection('content'); ?>
    <h2>Sprint planner</h2>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearSprintModal<?php echo e($proyecto->id); ?>">
        <i class="bi bi-plus-circle"></i> Crear Sprint
    </button>

    <div class="modal fade" id="crearSprintModal<?php echo e($proyecto->id); ?>" tabindex="-1" aria-labelledby="crearSprintModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearSprintModalLabel">Crear Sprint para <?php echo e($proyecto->nombre); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('sprints.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <!-- Campo oculto para pasar el proyecto_id -->
                        <input type="hidden" name="proyecto_id" value="<?php echo e($proyecto->id); ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Sprint</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="objetivo" class="form-label">Objetivo del Sprint</label>
                            <textarea class="form-control" name="objetivo"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" name="fecha_fin" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-control" name="estado" required>
                                <option value="Pendiente" selected>Pendiente</option>
                                
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Crear Sprint</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <table class="table">
        <thead>
            <tr>
                <th scope="col">Sprint</th>
                <th scope="col">Fecha de Inicio</th>
                <th scope="col">Fecha de Entrega</th>
                <th scope="col">Duración (días)</th>
                <th scope="col">Objetivos</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $sprints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><a href="<?php echo e(route('sprint-planner', $sprint->id)); ?>">
                        <?php echo e($sprint->nombre); ?>

                    </a></td>
                    <td><?php echo e(\Carbon\Carbon::parse($sprint->fecha_inicio)->format('d/m/Y')); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($sprint->fecha_fin)->format('d/m/Y')); ?></td>
                    <td>
                        <?php
                        // Calcular la duración en días
                        $inicio = \Carbon\Carbon::parse($sprint->fecha_inicio);
                        $fin = \Carbon\Carbon::parse($sprint->fecha_fin);
                        $duracion = $fin->diffInDays($inicio);
                        ?>
                        <?php echo e($duracion); ?> días
                    </td>
                    <td><?php echo e($sprint->objetivo); ?></td> <!-- Nueva columna para Objetivo -->
                    <td>
                        <!-- Botón de Editar -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editarSprintModal-<?php echo e($sprint->id); ?>">
                            <i class="bi bi-pencil"></i> Editar
                        </button>

                        <!-- Botón de Eliminar -->
                        <form action="<?php echo e(route('sprints.destroy', $sprint->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este sprint?');">
                                <i class="bi bi-trash3"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                <!-- Modal de Edición -->
                <div class="modal fade" id="editarSprintModal-<?php echo e($sprint->id); ?>" tabindex="-1"
                    aria-labelledby="editarSprintModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="<?php echo e(route('sprints.update', $sprint->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>

                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre del Sprint</label>
                                        <input type="text" class="form-control" name="nombre"
                                            value="<?php echo e($sprint->nombre); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="objetivo" class="form-label">Objetivo del Sprint</label>
                                        <textarea class="form-control" name="objetivo" required><?php echo e($sprint->objetivo); ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                        <input type="date" class="form-control" name="fecha_inicio"
                                            value="<?php echo e($sprint->fecha_inicio); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                                        <input type="date" class="form-control" name="fecha_fin"
                                            value="<?php echo e($sprint->fecha_fin); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select class="form-control" name="estado" required>
                                            <option value="Pendiente" <?php echo e($sprint->estado == 'Pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                                            <option value="En Proceso" <?php echo e($sprint->estado == 'En Proceso' ? 'selected' : ''); ?>>En Proceso</option>
                                            <option value="Completado" <?php echo e($sprint->estado == 'Completado' ? 'selected' : ''); ?>>Completado</option>
                                        </select>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasEstudiantes/planificacion.blade.php ENDPATH**/ ?>