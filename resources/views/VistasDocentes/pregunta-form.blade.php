
<form action="{{ $route }}" method="POST">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="texto{{ $pregunta->id ?? '' }}">Texto de la Pregunta</label>
        <input type="text" name="texto" class="form-control" id="texto{{ $pregunta->id ?? '' }}" value="{{ $pregunta->texto ?? old('texto') }}" required>
    </div>

    <div class="form-group">
        <label for="tipo{{ $pregunta->id ?? '' }}">Tipo de Pregunta</label>
        <select name="tipo" class="form-control" id="tipo{{ $pregunta->id ?? '' }}" required>
            <option value="f/v" {{ (isset($pregunta) && $pregunta->tipo == 'f/v') ? 'selected' : '' }}>f/v</option>
            <option value="escala_1_5" {{ (isset($pregunta) && $pregunta->tipo == 'escala_1_5') ? 'selected' : '' }}>Escala 1-5</option>
            <option value="respuesta_corta" {{ (isset($pregunta) && $pregunta->tipo == 'respuesta_corta') ? 'selected' : '' }}>Respuesta Corta</option>
            <option value="opcion_multiple" {{ (isset($pregunta) && $pregunta->tipo == 'opcion_multiple') ? 'selected' : '' }}>Opción Múltiple</option>
        </select>
    </div>

    <div class="form-group">
        <label for="evaluacion{{ $pregunta->id ?? '' }}">Tipo de Evaluación</label>
        <select name="evaluacion" class="form-control" id="evaluacion{{ $pregunta->id ?? '' }}" required>
            <option value="autoevaluacion" {{ (isset($pregunta) && $pregunta->evaluacion == 'autoevaluacion') ? 'selected' : '' }}>Autoevaluación</option>
            <option value="cruzada" {{ (isset($pregunta) && $pregunta->evaluacion == 'cruzada') ? 'selected' : '' }}>Cruzada</option>
            <option value="porpares" {{ (isset($pregunta) && $pregunta->evaluacion == 'porpares') ? 'selected' : '' }}>Por Pares</option>
        </select>
    </div>

    <div class="form-group">
        <label for="estado{{ $pregunta->id ?? '' }}">Estado</label>
        <select name="estado" class="form-control" id="estado{{ $pregunta->id ?? '' }}" required>
            <option value="activo" {{ (isset($pregunta) && $pregunta->estado == 'activo') ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ (isset($pregunta) && $pregunta->estado == 'inactivo') ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
</form>
