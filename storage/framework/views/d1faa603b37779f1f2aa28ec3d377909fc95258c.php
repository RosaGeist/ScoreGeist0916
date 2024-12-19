

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Publicar un Aviso</h1>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearAviso">
            Crear nuevo aviso
        </button>

        <div class="modal fade" id="crearAviso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="crearAvisoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="crearAvisoLabel">Nuevo aviso</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo e(route('avisos.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <label for="grupo_id">Grupo</label>
                                <select name="grupo_id" id="grupo_id" class="form-control" required>
                                    <option value="">Seleccione un grupo</option>
                                    <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grupo->id); ?>"><?php echo e($grupo->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="titulo">Título del Aviso</label>
                                <input type="text" name="titulo" class="form-control" id="titulo" required>
                            </div>

                            <div class="form-group">
                                <label for="contenido">Contenido del Aviso</label>
                                <textarea name="contenido" class="form-control" id="contenido" rows="5" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Publicar Aviso</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php $__currentLoopData = $avisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aviso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($aviso->titulo); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Grupo: <?php echo e($aviso->grupo->nombre); ?></h6>
                            <p class="card-text"><?php echo e($aviso->contenido); ?></p>
                            <p class="text-muted"><small>Publicado el: <?php echo e($aviso->created_at->format('d/m/Y')); ?></small></p>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editarAvisos<?php echo e($aviso->id); ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="<?php echo e(route('avisos.destroy', $aviso->id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Está seguro de eliminar este aviso?')"><i
                                        class="bi bi-trash3"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editarAvisos<?php echo e($aviso->id); ?>" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarAvisos<?php echo e($aviso->id); ?>Label"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editarAvisos<?php echo e($aviso->id); ?>Label">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo e(route('avisos.update', $aviso->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>


                                    <div class="form-group">
                                        <label for="grupo_id">Grupo</label>
                                        <select name="grupo_id" class="form-control" required>
                                            <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($grupo->id); ?>"
                                                    <?php echo e($grupo->id == $aviso->grupo_id ? 'selected' : ''); ?>>
                                                    <?php echo e($grupo->nombre); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="titulo">Título del Aviso</label>
                                        <input type="text" name="titulo" class="form-control"
                                            value="<?php echo e($aviso->titulo); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="contenido">Contenido del Aviso</label>
                                        <textarea name="contenido" class="form-control" rows="5" required><?php echo e($aviso->contenido); ?></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasDocentes/avisos.blade.php ENDPATH**/ ?>