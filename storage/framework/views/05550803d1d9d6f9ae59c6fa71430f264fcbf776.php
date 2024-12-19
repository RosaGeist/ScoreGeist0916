
<form action="<?php echo e($route); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field($method); ?>
    <div class="form-group">
        <label for="texto<?php echo e($pregunta->id ?? ''); ?>">Texto de la Pregunta</label>
        <input type="text" name="texto" class="form-control" id="texto<?php echo e($pregunta->id ?? ''); ?>" value="<?php echo e($pregunta->texto ?? old('texto')); ?>" required>
    </div>

    <div class="form-group">
        <label for="tipo<?php echo e($pregunta->id ?? ''); ?>">Tipo de Pregunta</label>
        <select name="tipo" class="form-control" id="tipo<?php echo e($pregunta->id ?? ''); ?>" required>
            <option value="f/v" <?php echo e((isset($pregunta) && $pregunta->tipo == 'f/v') ? 'selected' : ''); ?>>f/v</option>
            <option value="escala_1_5" <?php echo e((isset($pregunta) && $pregunta->tipo == 'escala_1_5') ? 'selected' : ''); ?>>Escala 1-5</option>
            <option value="respuesta_corta" <?php echo e((isset($pregunta) && $pregunta->tipo == 'respuesta_corta') ? 'selected' : ''); ?>>Respuesta Corta</option>
            <option value="opcion_multiple" <?php echo e((isset($pregunta) && $pregunta->tipo == 'opcion_multiple') ? 'selected' : ''); ?>>Opción Múltiple</option>
        </select>
    </div>

    <div class="form-group">
        <label for="evaluacion<?php echo e($pregunta->id ?? ''); ?>">Tipo de Evaluación</label>
        <select name="evaluacion" class="form-control" id="evaluacion<?php echo e($pregunta->id ?? ''); ?>" required>
            <option value="autoevaluacion" <?php echo e((isset($pregunta) && $pregunta->evaluacion == 'autoevaluacion') ? 'selected' : ''); ?>>Autoevaluación</option>
            <option value="cruzada" <?php echo e((isset($pregunta) && $pregunta->evaluacion == 'cruzada') ? 'selected' : ''); ?>>Cruzada</option>
            <option value="porpares" <?php echo e((isset($pregunta) && $pregunta->evaluacion == 'porpares') ? 'selected' : ''); ?>>Por Pares</option>
        </select>
    </div>

    <div class="form-group">
        <label for="estado<?php echo e($pregunta->id ?? ''); ?>">Estado</label>
        <select name="estado" class="form-control" id="estado<?php echo e($pregunta->id ?? ''); ?>" required>
            <option value="activo" <?php echo e((isset($pregunta) && $pregunta->estado == 'activo') ? 'selected' : ''); ?>>Activo</option>
            <option value="inactivo" <?php echo e((isset($pregunta) && $pregunta->estado == 'inactivo') ? 'selected' : ''); ?>>Inactivo</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary"><?php echo e($buttonText); ?></button>
</form>
<?php /**PATH C:\Taller de ingenieria de software\ScoreGeist\resources\views/VistasDocentes/pregunta-form.blade.php ENDPATH**/ ?>