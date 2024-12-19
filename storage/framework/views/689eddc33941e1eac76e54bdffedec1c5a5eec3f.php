

<?php $__env->startSection('content'); ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
            <li class="breadcrumb-item"><a href="/sprint-planner">Sprint Planner</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('historias.show', $sprint->id)); ?>"><?php echo e($sprint->nombre); ?></a></li>

        </ol>
    </nav>
    <div class="container">
        <h1 class="d-flex justify-content-between align-items-center">
            Sprint: <?php echo e($sprint->nombre); ?>

            <?php if(Auth::id() === $sprint->proyecto->equipo->creador_id): ?>
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                    data-bs-target="#crearHistoriaModal">
                    <i class="bi bi-plus-circle"></i> Crear Historia de Usuario
                </button>
            <?php endif; ?>
        </h1>

        <div class="card">
            <div class="card-body p-3">
                <p class="mb-2"><strong>Proyecto:</strong> <?php echo e($sprint->proyecto->nombre); ?></p>
                <p class="mb-2"><strong>Objetivo:</strong> <?php echo e($sprint->objetivo); ?></p>
                <div class="d-flex justify-content-between mb-2">
                    <p class="mb-0"><strong>Fecha de Inicio:</strong>
                        <?php echo e(\Carbon\Carbon::parse($sprint->fecha_inicio)->locale('es')->isoFormat('D [de] MMMM [de] YYYY')); ?>

                    </p>
                    <p class="mb-0"><strong>Fecha de Fin:</strong>
                        <?php echo e(\Carbon\Carbon::parse($sprint->fecha_fin)->locale('es')->isoFormat('D [de] MMMM [de] YYYY')); ?>

                    </p>
                </div>
                <hr>
                <p class="mb-2"><strong>Comentarios:</strong></p>
                <?php $__empty_1 = true; $__currentLoopData = $sprint->comentarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <p class="mb-2"><strong><?php echo e($comentario->docente->name); ?></strong>: <?php echo e($comentario->contenido); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>No hay comentarios.</p>
                <?php endif; ?>
            </div>
          
                
         
            
        </div>

        <div class="modal fade" id="crearHistoriaModal" tabindex="-1" aria-labelledby="crearHistoriaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="crearHistoriaModalLabel">Crear Historia de Usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo e(route('historias.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="prioridad" class="form-label">Prioridad</label>
                                <select class="form-select" id="prioridad" name="prioridad" required>
                                    <option value="Alta">Alta</option>
                                    <option value="Media">Media</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="En progreso">En progreso</option>
                                    <option value="Completada">Completada</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="criterios_aceptacion" class="form-label">Criterios de Aceptación</label>
                                <textarea class="form-control" id="criterios_aceptacion" name="criterios_aceptacion" required></textarea>
                            </div>
                            <!-- Sprint ID oculto, ya que se pasa desde el enlace -->
                            <input type="hidden" name="sprints_id" value="<?php echo e($sprint->id); ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear Historia</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <h2>Historias de Usuario</h2>
            <?php if($sprint->historias->isEmpty()): ?>
                <p>No hay historias de usuario para este sprint.</p>
            <?php else: ?>
                <?php $__currentLoopData = $sprint->historias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #5CCFCF;">
                            <div>
                                <h4 class="mb-0">H.U. <?php echo e($historia->titulo); ?></h4>
                                <span class="badge bg-primary">Prioridad: <?php echo e($historia->prioridad); ?></span>
                                <span class="badge bg-<?php echo e($historia->estado == 'completado' ? 'success' : 'warning'); ?>">
                                    Estado: <?php echo e(ucfirst($historia->estado)); ?>

                                </span>
                            </div>
                            <?php if(Auth::id() === $sprint->proyecto->equipo->creador_id): ?>
                                <div>

                                    <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                        data-bs-target="#editarHistoriaModal<?php echo e($historia->id); ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>


                                    <div class="modal fade" id="editarHistoriaModal<?php echo e($historia->id); ?>" tabindex="-1"
                                        aria-labelledby="editarHistoriaModalLabel<?php echo e($historia->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editarHistoriaModalLabel<?php echo e($historia->id); ?>">Editar Historia
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?php echo e(route('historias.update', $historia->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <div class="mb-3">
                                                            <label for="titulo" class="form-label">Título</label>
                                                            <input type="text" class="form-control" id="titulo"
                                                                name="titulo" value="<?php echo e($historia->titulo); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="descripcion"
                                                                class="form-label">Descripción</label>
                                                            <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo e($historia->descripcion); ?></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="prioridad" class="form-label">Prioridad</label>
                                                            <select class="form-control" id="prioridad" name="prioridad"
                                                                required>
                                                                <option value="Alta"
                                                                    <?php echo e($historia->prioridad == 'Alta' ? 'selected' : ''); ?>>
                                                                    Alta</option>
                                                                <option value="Media"
                                                                    <?php echo e($historia->prioridad == 'Media' ? 'selected' : ''); ?>>
                                                                    Media</option>
                                                                <option value="Baja"
                                                                    <?php echo e($historia->prioridad == 'Baja' ? 'selected' : ''); ?>>
                                                                    Baja</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="estado" class="form-label">Estado</label>
                                                            <select class="form-control" id="estado" name="estado"
                                                                required>
                                                                <option value="pendiente"
                                                                    <?php echo e($historia->estado == 'pendiente' ? 'selected' : ''); ?>>
                                                                    Pendiente</option>
                                                                <option value="en progreso"
                                                                    <?php echo e($historia->estado == 'en progreso' ? 'selected' : ''); ?>>
                                                                    En Progreso</option>
                                                                <option value="completado"
                                                                    <?php echo e($historia->estado == 'completado' ? 'selected' : ''); ?>>
                                                                    Completado</option>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Guardar
                                                            Cambios</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="<?php echo e(route('historias.destroy', $historia->id)); ?>" method="POST"
                                        style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger text-white"
                                            onclick="return confirm('¿Estás seguro de eliminar esta historia?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body">
                            <p><strong>Descripción:</strong> <?php echo e($historia->descripcion); ?></p>
                            <p><strong>Criterios de Aceptación:</strong> <?php echo e($historia->criterios_aceptacion); ?></p>

                           

                            <div class="d-flex justify-content-between align-items-center">
                                <h2>Subtareas</h2>
                                <?php if(Auth::id() === $sprint->proyecto->equipo->creador_id): ?>
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modalSubtarea<?php echo e($historia->id); ?>">
                                        <i class="bi bi-plus-circle"></i> Agregar Subtarea
                                    </button>
                                <?php endif; ?>
                            </div>

                            <div class="modal fade" id="modalSubtarea<?php echo e($historia->id); ?>" tabindex="-1"
                                aria-labelledby="modalSubtareaLabel<?php echo e($historia->id); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalSubtareaLabel<?php echo e($historia->id); ?>">Crear
                                                Subtarea
                                                para: <?php echo e($historia->titulo); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="<?php echo e(route('subtareas.store', $historia->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="mb-3">
                                                    <label for="titulo" class="form-label">Título de la Subtarea</label>
                                                    <input type="text" class="form-control" id="titulo"
                                                        name="titulo" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="estado" class="form-label">Estado</label>
                                                    <select class="form-control" id="estado" name="estado" required>
                                                        <option value="Pendiente">Pendiente</option>
                                                        <option value="En Progreso">En Progreso</option>
                                                        <option value="Completada">Completada</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="miembro_asignado" class="form-label">Miembro
                                                        Asignado</label>
                                                    <select class="form-control" id="miembro_asignado"
                                                        name="miembro_asignado" required>
                                                        <option value="">Seleccionar Miembro</option>
                                                        <?php $__currentLoopData = $miembros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miembro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($miembro->id); ?>"><?php echo e($miembro->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-success">Guardar Subtarea</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if($historia->subtareas->isEmpty()): ?>
                                <p>No hay subtareas asignadas.</p>
                            <?php else: ?>
                                <?php $__currentLoopData = $historia->subtareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-md-10">
                                                <h4 class="mb-0"><?php echo e($subtarea->titulo); ?></h4>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-dark p-0" type="button"
                                                        id="dropdownMenuButton<?php echo e($subtarea->id); ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-list" style="font-size: 24px; color: black;"></i>
                                                    </button>

                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton<?php echo e($subtarea->id); ?>">
                                                        <?php if(Auth::id() === $sprint->proyecto->equipo->creador_id): ?>
                                                            <li>

                                                                <form
                                                                    action="<?php echo e(route('subtareas.destroy', $subtarea->id)); ?>"
                                                                    method="POST" style="display:inline;">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="dropdown-item text-dark"
                                                                        style="color: black; font-weight: normal;"
                                                                        onclick="return confirm('¿Estás seguro de eliminar esta subtarea?')">
                                                                        <i class="bi bi-trash" style="color: red;"></i>
                                                                        Eliminar
                                                                    </button>

                                                                </form>
                                                            </li>
                                                        <?php endif; ?>

                                                        <li>
                                                            <button type="button" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editarSubtareaModal<?php echo e($subtarea->id); ?>" style="color: black; font-weight: normal;">
                                                                <?php if(Auth::id() === $sprint->proyecto->equipo->creador_id): ?>
                                                                    <i class="bi bi-pencil" style="color: rgb(255, 238, 0)";></i> Editar
                                                                <?php else: ?>
                                                                    <i class="bi bi-pencil" style="color:  rgb(255, 238, 0)";></";></i> Editar estado
                                                                <?php endif; ?>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <strong>Descripción:</strong> <?php echo e($subtarea->descripcion); ?> <br>
                                        <strong>Asignado a:</strong>
                                        <?php echo e($subtarea->miembroAsignado ? $subtarea->miembroAsignado->name : 'Sin asignar'); ?>

                                        <br>

                                        <!-- Estado con Badge -->
                                        <strong>Estado:</strong>
                                        <?php if($subtarea->estado == 'Pendiente'): ?>
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        <?php elseif($subtarea->estado == 'En Progreso'): ?>
                                            <span class="badge bg-primary">En Progreso</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Completada</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="modal fade" id="editarSubtareaModal<?php echo e($subtarea->id); ?>" tabindex="-1"
                                        aria-labelledby="editarSubtareaModalLabel<?php echo e($subtarea->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editarSubtareaModalLabel<?php echo e($subtarea->id); ?>">
                                                        <?php if(Auth::id() === $sprint->proyecto->equipo->creador_id): ?>
                                                            Editar Subtarea: <?php echo e($subtarea->titulo); ?>

                                                        <?php else: ?>
                                                            Editar estado de: <?php echo e($subtarea->titulo); ?>

                                                        <?php endif; ?>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?php echo e(route('subtareas.update', $subtarea->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>

                                                        <!-- Título de la Subtarea (solo editable por el creador) -->
                                                        <?php if(Auth::id() === $sprint->proyecto->equipo->creador_id): ?>
                                                            <div class="mb-3">
                                                                <label for="titulo" class="form-label">Título de la
                                                                    Subtarea</label>
                                                                <input type="text" class="form-control" id="titulo"
                                                                    name="titulo" value="<?php echo e($subtarea->titulo); ?>"
                                                                    required>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="mb-3">
                                                                <label for="titulo" class="form-label">Título de la
                                                                    Subtarea</label>
                                                                <input type="text" class="form-control" id="titulo"
                                                                    name="titulo" value="<?php echo e($subtarea->titulo); ?>"
                                                                    disabled>
                                                                <!-- Campo oculto para el título -->
                                                                <input type="hidden" name="titulo"
                                                                    value="<?php echo e($subtarea->titulo); ?>">
                                                            </div>
                                                        <?php endif; ?>

                                                        <!-- Descripción (solo editable por el creador) -->
                                                        <?php if(Auth::id() === $sprint->proyecto->equipo->creador_id): ?>
                                                            <div class="mb-3">
                                                                <label for="descripcion"
                                                                    class="form-label">Descripción</label>
                                                                <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo e($subtarea->descripcion); ?></textarea>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="mb-3">
                                                                <label for="descripcion"
                                                                    class="form-label">Descripción</label>
                                                                <textarea class="form-control" id="descripcion" name="descripcion" disabled><?php echo e($subtarea->descripcion); ?></textarea>
                                                                <!-- Campo oculto para la descripción -->
                                                                <input type="hidden" name="descripcion"
                                                                    value="<?php echo e($subtarea->descripcion); ?>">
                                                            </div>
                                                        <?php endif; ?>

                                                        <!-- Estado (siempre editable) -->
                                                        <div class="mb-3">
                                                            <label for="estado" class="form-label">Estado</label>
                                                            <select class="form-control" id="estado" name="estado"
                                                                required>
                                                                <option value="Pendiente"
                                                                    <?php echo e($subtarea->estado == 'Pendiente' ? 'selected' : ''); ?>>
                                                                    Pendiente</option>
                                                                <option value="En Progreso"
                                                                    <?php echo e($subtarea->estado == 'En Progreso' ? 'selected' : ''); ?>>
                                                                    En Progreso</option>
                                                                <option value="Completada"
                                                                    <?php echo e($subtarea->estado == 'Completada' ? 'selected' : ''); ?>>
                                                                    Completada</option>
                                                            </select>
                                                        </div>

                                                        <!-- Miembro Asignado (solo editable por el creador) -->
                                                        <?php if(Auth::id() === $sprint->proyecto->equipo->creador_id): ?>
                                                            <div class="mb-3">
                                                                <label for="miembro_asignado" class="form-label">Miembro
                                                                    Asignado</label>
                                                                <select class="form-control" id="miembro_asignado"
                                                                    name="miembro_asignado">
                                                                    <option value="">Seleccionar Miembro</option>
                                                                    <?php $__currentLoopData = $miembros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miembro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($miembro->id); ?>"
                                                                            <?php echo e($subtarea->miembroAsignado && $subtarea->miembroAsignado->id == $miembro->id ? 'selected' : ''); ?>>
                                                                            <?php echo e($miembro->name); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="mb-3">
                                                                <label for="miembro_asignado" class="form-label">Miembro
                                                                    Asignado</label>
                                                                <input type="text" class="form-control"
                                                                    id="miembro_asignado"
                                                                    value="<?php echo e($subtarea->miembroAsignado ? $subtarea->miembroAsignado->name : 'Ninguno'); ?>"
                                                                    disabled>
                                                                <!-- Campo oculto para el miembro asignado -->
                                                                <input type="hidden" name="miembro_asignado"
                                                                    value="<?php echo e($subtarea->miembroAsignado ? $subtarea->miembroAsignado->id : ''); ?>">
                                                            </div>
                                                        <?php endif; ?>

                                                        <button type="submit" class="btn btn-success">
                                                            Actualizar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasEstudiantes/sprint-detalle.blade.php ENDPATH**/ ?>