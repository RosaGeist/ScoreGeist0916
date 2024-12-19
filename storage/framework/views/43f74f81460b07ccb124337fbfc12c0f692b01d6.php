

<?php $__env->startSection('content'); ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
            <li class="breadcrumb-item"><a href="/sprint-planner">Sprint Planner</a></li>
        </ol>
    </nav>
    <div class="container">
        <h1>Mis Proyectos y Sprints</h1>

        <?php if($proyectos->isEmpty()): ?>
            <p>No tienes proyectos asignados.</p>
        <?php else: ?>
            <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card my-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><?php echo e($proyecto->nombre); ?></h3>
                        <?php if(Auth::id() === $proyecto->equipo->creador_id): ?>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#crearSprintModal" onclick="setProyectoId(<?php echo e($proyecto->id); ?>)">
                                Crear Sprint
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo e($proyecto->descripcion); ?></p>
                    </div>
                </div>

                <div class="card-body">
                    <?php if($proyecto->sprints->isEmpty()): ?>
                        <p>No hay sprints disponibles para este proyecto.</p>
                    <?php else: ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sprint</th>
                                    <th class="col-fecha">Fecha de Inicio</th>
                                    <th class="col-fecha">Fecha de Fin</th>
                                    <th>Duración (días)</th>
                                    <?php if(Auth::id() === $proyecto->equipo->creador_id): ?>
                                        <th>Acciones</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $proyecto->sprints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sprint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td>
                                            <div>
                                                <a href="<?php echo e(route('historias.show', $sprint->id)); ?>"
                                                    class="text-decoration-none">
                                                    <?php echo e($sprint->nombre); ?>

                                                </a>
                                                <?php if($sprint->estado == 'Pendiente'): ?>
                                                    <span class="badge text-bg-primary"><?php echo e($sprint->estado); ?></span>
                                                <?php elseif($sprint->estado == 'En Proceso'): ?>
                                                    <span class="badge text-bg-secondary"><?php echo e($sprint->estado); ?></span>
                                                <?php elseif($sprint->estado == 'Completado'): ?>
                                                    <span class="badge text-bg-success"><?php echo e($sprint->estado); ?></span>
                                                    <a href="<?php echo e(route('autoevaluacion.formulario', $sprint->id)); ?>"
                                                        class="btn btn-success">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <div><strong>Objetivo:</strong> <?php echo e($sprint->objetivo); ?></div>
                                        </td>
                                        <td class="col-fecha"><?php echo e($sprint->fecha_inicio); ?></td>
                                        <td class="col-fecha"><?php echo e($sprint->fecha_fin); ?></td>
                                        <td>
                                            <?php
                                                $fecha_inicio = \Carbon\Carbon::parse($sprint->fecha_inicio);
                                                $fecha_fin = \Carbon\Carbon::parse($sprint->fecha_fin);
                                                $duracion = $fecha_inicio->diffInDays($fecha_fin);
                                            ?>
                                            <?php echo e($duracion); ?> días
                                        </td>
                                        <?php if(Auth::id() === $proyecto->equipo->creador_id): ?>
                                            <td>
                                                <form action="<?php echo e(route('sprints.destroy', $sprint->id)); ?>" method="POST"
                                                    class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este sprint?');">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editarSprintModal-<?php echo e($sprint->id); ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <div class="modal fade" id="editarSprintModal-<?php echo e($sprint->id); ?>"
                                                    tabindex="-1" aria-labelledby="editarSprintModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editarSprintModalLabel">Editar
                                                                    Sprint</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo e(route('sprints.update', $sprint->id)); ?>"
                                                                    method="POST">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('PUT'); ?>

                                                                    <!-- Campo de Nombre -->
                                                                    <div class="mb-3">
                                                                        <label for="nombre"
                                                                            class="form-label text-start">Nombre del
                                                                            Sprint</label>
                                                                        <input type="text" class="form-control"
                                                                            name="nombre" value="<?php echo e($sprint->nombre); ?>"
                                                                            required>
                                                                    </div>

                                                                    <!-- Campo de Objetivo -->
                                                                    <div class="mb-3">
                                                                        <label for="objetivo"
                                                                            class="form-label text-start">Objetivo del
                                                                            Sprint</label>
                                                                        <textarea class="form-control" name="objetivo" required><?php echo e($sprint->objetivo); ?></textarea>
                                                                    </div>

                                                                    <!-- Campo de Fecha de Inicio -->
                                                                    <div class="mb-3">
                                                                        <label for="fecha_inicio"
                                                                            class="form-label text-start">Fecha de
                                                                            Inicio</label>
                                                                        <input type="date" class="form-control"
                                                                            name="fecha_inicio"
                                                                            value="<?php echo e($sprint->fecha_inicio); ?>" required>
                                                                    </div>

                                                                    <!-- Campo de Fecha de Fin -->
                                                                    <div class="mb-3">
                                                                        <label for="fecha_fin"
                                                                            class="form-label text-start">Fecha de
                                                                            Fin</label>
                                                                        <input type="date" class="form-control"
                                                                            name="fecha_fin"
                                                                            value="<?php echo e($sprint->fecha_fin); ?>" required>
                                                                    </div>

                                                                    <!-- Campo de Estado del Sprint -->
                                                                    <div class="mb-3">
                                                                        <label for="estado"
                                                                            class="form-label text-start">Estado del
                                                                            Sprint</label>
                                                                        <select class="form-control" name="estado"
                                                                            required>
                                                                            <option value="Pendiente"
                                                                                <?php echo e($sprint->estado == 'Pendiente' ? 'selected' : ''); ?>>
                                                                                Pendiente</option>
                                                                            <option value="En Proceso"
                                                                                <?php echo e($sprint->estado == 'En Proceso' ? 'selected' : ''); ?>>
                                                                                En Proceso</option>
                                                                            <option value="Completado"
                                                                                <?php echo e($sprint->estado == 'Completado' ? 'selected' : ''); ?>>
                                                                                Completado</option>
                                                                        </select>
                                                                    </div>

                                                                    <!-- Botones del Modal -->
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cerrar</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Guardar
                                                                            Cambios</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="crearSprintModal" tabindex="-1" aria-labelledby="crearSprintModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearSprintModalLabel">Crear Sprint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('sprints.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <!-- Campo oculto para pasar el proyecto_id -->
                        <input type="hidden" id="proyecto-id-input" name="proyecto_id">

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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Crear Sprint</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    </div>

    <script>
        function setProyectoId(proyectoId) {
            document.getElementById('proyecto-id-input').value = proyectoId;
        }
    </script>


    <style>
        .col-fecha {
            width: 150px;
            white-space: nowrap;
            text-align: center;
        }
    </style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasEstudiantes/sprint-planner.blade.php ENDPATH**/ ?>