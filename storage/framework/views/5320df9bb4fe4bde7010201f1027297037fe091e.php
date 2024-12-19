

<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/docente/dashboard">Página principal</a></li>
        <li class="breadcrumb-item"><a href="/grupos">Grupos</a></li>
    </ol>
</nav>
    <h1>Grupos</h1>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarGrupo">
        <i class="bi bi-plus-circle"></i> Añadir grupo
    </button>
    <div class="modal fade" id="agregarGrupo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="agregarGrupoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="<?php echo e(route('grupos.store')); ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="agregarGrupoLabel">Crear grupo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                     
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="nombre">Nombre del Grupo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Crear Grupo</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-4">
        <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex align-items-center">
                            <div class="col-6 text-start">
                                <h4 class="card-title">
                                    <a href="<?php echo e(route('grupo.avisos', $grupo->id)); ?>"><?php echo e($grupo->nombre); ?></a>
                                </h4>
                            </div>
                            <div class="col-6 text-end">
                                <div class="botonesAccion">
                                   
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarGrupo<?php echo e($grupo->id); ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="<?php echo e(route('grupos.destroy', $grupo->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este grupo?');">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                       
                        
                        <p class="card-text"><?php echo e($grupo->descripcion); ?></p>
                        <p><b>Código grupo:</b> <?php echo e($grupo->codigo); ?></p>
                        
                        <form action="<?php echo e(route('grupo.agregarEstudiante')); ?>" method="POST" class="d-flex align-items-center mt-3">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="grupo_id" value="<?php echo e($grupo->id); ?>">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-plus-circle"></i> Agregar miembros
                            </button>
                            <select class="form-select" name="usuario_id" required style="width: 350px;">
                                <option selected disabled>Selecciona un estudiante</option>
                                <?php $__currentLoopData = $usuariosPorGrupo[$grupo->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($usuario->id); ?>"><?php echo e($usuario->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>
            
                        <h5 class="mt-3">Inscritos</h5>
                        <ul class="list-group mb-3">
                            <?php $__empty_1 = true; $__currentLoopData = $grupo->usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miembro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e($miembro->name); ?>

                                    <span class="badge bg-primary rounded-pill">Estudiante</span>
                                
                                <form action="<?php echo e(route('grupo.eliminarEstudiante', ['grupo' => $grupo->id, 'usuario' => $miembro->id])); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar a este estudiante del grupo?');">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="list-group-item text-muted">No hay estudiantes en este grupo.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="editarGrupo<?php echo e($grupo->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="editarGrupo<?php echo e($grupo->id); ?>Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editarGrupo<?php echo e($grupo->id); ?>Label">Editar grupo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo e(route('grupos.update', $grupo->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="form-group">
                                    <label for="nombre">Nombre del Grupo</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        value="<?php echo e(old('nombre', $grupo->nombre)); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo e(old('descripcion', $grupo->descripcion)); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="codigo">Código del Grupo</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="codigo" name="codigo"
                                            value="<?php echo e($grupo->codigo); ?>" readonly>
                                        <button type="button" class="btn btn-secondary" id="generarCodigo">Generar
                                            Código</button>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-success">Actualizar Grupo</button>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        document.getElementById('generarCodigo').addEventListener('click', function() {
            const codigoAleatorio = Math.random().toString(36).substring(2, 8).toUpperCase(); // Cambia a mayúsculas
            document.getElementById('codigo').value = codigoAleatorio;
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasDocentes/grupo.blade.php ENDPATH**/ ?>