@extends('layouts.menu')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
        <li class="breadcrumb-item">{{$equipo->nombre_empresa}}</li>
        <li class="breadcrumb-item">Autoevaluaciones y por pares</li>
    </ol>
</nav>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Autoevaluación para el Sprint: <strong>{{ $sprint->nombre }}</strong></h2>
            </div>
            <div class="card-body">
                {{-- Mostrar respuestas del usuario autenticado --}}
                <h3 class="text-secondary">Tus respuestas</h3>
                <form>
                    @csrf
                    @foreach ($preguntasAutoevaluacion as $pregunta)
                        <div class="mb-3">
                            <label class="form-label fw-bold"
                                for="pregunta_{{ $pregunta->id }}">{{ $pregunta->texto }}</label>
                            @php
                                $respuesta = $respuestasUsuario->where('pregunta_id', $pregunta->id)->first();
                            @endphp
                            <input type="text" class="form-control" value="{{ $respuesta->respuesta ?? 'No respondida' }}"
                                disabled>
                        </div>
                    @endforeach
                </form>
            </div>
        </div>

        @if ($equipo)
            <div class="card shadow-lg mt-4">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Respuestas de tus compañeros de equipo</h3>
                </div>
                <div class="card-body">
                    @foreach ($respuestasMiembros as $usuarioId => $respuestas)
                        @php
                            $miembro = $equipo->miembros->where('id', $usuarioId)->first();
                        @endphp
                        <div class="mb-4">
                            <h4 class="text-info">Evaluación de: <strong>{{ $miembro->name }}</strong></h4>
                            @foreach ($preguntasAutoevaluacion as $pregunta)
                                <div class="mb-2">
                                    <label class="form-label">{{ $pregunta->texto }}</label>
                                    @php
                                        $respuesta = $respuestas->where('pregunta_id', $pregunta->id)->first();
                                    @endphp
                                    <input type="text" class="form-control"
                                        value="{{ $respuesta->respuesta ?? 'No respondida' }}" disabled>
                                </div>
                            @endforeach

                            {{-- Botón para abrir el modal de evaluación --}}
                            @if ($miembro->id != auth()->id())
                                <!-- Solo mostrar el botón si no es el usuario autenticado -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalEvaluacion{{ $miembro->id }}">
                                    Evaluar a {{ $miembro->name }}
                                </button>
                            @endif
                            {{-- Mostrar respuestas de evaluación por pares de los compañeros del equipo --}}
                            <h3>Respuestas de Evaluación por Pares de tus Compañeros de Equipo</h3>

                            @foreach ($respuestasEvaluacionPorParesMiembros as $usuarioId => $respuestas)
                            @php
                            // Obtener la respuesta que contiene el usuario que evaluó
                            $respuesta = $respuestas->first();
                    
                            // Acceder al evaluador (usuario_id)
                            $evaluador = $respuesta->usuario; // Esto usará la relación 'usuario' definida en el modelo RespuestaPorPares
                        @endphp
                    
                        <h4>Evaluado por: {{ $evaluador->name }}</h4> 
                                @foreach ($preguntasPorPares as $pregunta)
                                    <div class="form-group">
                                        <label for="pregunta_{{ $pregunta->id }}">
                                            {{ $pregunta->texto }}
                                        </label>

                                        {{-- Buscar la respuesta dada por los compañeros para la pregunta actual --}}
                                        @php
                                            $respuesta = $respuestas->where('pregunta_id', $pregunta->id)->first();
                                        @endphp

                                        {{-- Si hay respuesta, mostrarla, si no, indicar que no ha sido respondida --}}
                                        <input type="text" class="form-control"
                                            value="{{ $respuesta->respuesta ?? 'No respondida' }}" disabled>
                                    </div>
                                @endforeach
                            @endforeach

                        </div>

                        {{-- Modal de evaluación por pares --}}
                        <div class="modal fade" id="modalEvaluacion{{ $usuarioId }}" tabindex="-1"
                            aria-labelledby="modalLabel{{ $usuarioId }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalLabel{{ $usuarioId }}">Evaluar a:
                                            {{ $miembro->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('guardarEvaluacionPorPares', $sprint->id) }}"
                                            method="POST">
                                            @csrf
                                            @foreach ($preguntasPorPares as $pregunta)
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ $pregunta->texto }}</label>
                                                    <input type="number" class="form-control"
                                                        name="evaluaciones[{{ $usuarioId }}][{{ $pregunta->id }}]"
                                                        placeholder="Calificación (1-10)" required>
                                                </div>
                                            @endforeach
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
                    @endforeach
                </div>
            </div>
        @else
            <div class="alert alert-warning mt-4">No estás asignado a ningún equipo.</div>
        @endif
    </div>
@endsection
