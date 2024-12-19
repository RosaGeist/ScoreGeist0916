@extends('layouts.menu')

@section('content')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearPreguntaModal">
    <i class="bi bi-plus-circle"></i> Crear Nueva Pregunta
</button>

<!-- Modal para crear pregunta -->
<div class="modal fade" id="crearPreguntaModal" tabindex="-1" aria-labelledby="crearPreguntaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearPreguntaModalLabel">Nueva Pregunta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Incluyendo el formulario de creación -->
                @include('VistasDocentes.pregunta-form', [
                    'route' => route('preguntas.store'),
                    'method' => 'POST',
                    'buttonText' => 'Guardar Pregunta'
                ])
            </div>
        </div>
    </div>
</div>

@foreach(['autoevaluacion', 'cruzada', 'porpares'] as $evaluacion)
    <div class="card mb-3">
        <div class="card-header bg-{{ $loop->index === 0 ? 'primary' : ($loop->index === 1 ? 'success' : 'info') }} text-white">
            <i class="bi bi-check-circle"></i> Evaluación: {{ ucfirst($evaluacion) }}
        </div>
        <div class="card-body">
            @if(isset($preguntasAgrupadas[$evaluacion]))
                <ul class="list-group">
                    @foreach($preguntasAgrupadas[$evaluacion] as $pregunta)
                        <li class="list-group-item">
                            <strong>{{ $pregunta->texto }}</strong><br>
                            <span><i class="bi bi-question-square"></i></i> Tipo: {{ ucfirst(str_replace('_', ' ', $pregunta->tipo)) }}</span><br>
                            <span><i class="bi bi-check-circle"></i> Estado: {{ $pregunta->estado }}</span>
                            <form action="{{ route('preguntas.destroy', $pregunta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</button>
                            </form>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarPregunta{{ $pregunta->id }}"><i class="bi bi-pencil"></i> Editar</button>
                        </li>
                        <!-- Modal para editar pregunta -->
                        <div class="modal fade" id="editarPregunta{{ $pregunta->id }}" tabindex="-1" aria-labelledby="editarPregunta{{ $pregunta->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editarPregunta{{ $pregunta->id }}Label">Editar Pregunta</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Incluyendo el formulario de edición -->
                                        @include('VistasDocentes.pregunta-form', [
                                            'route' => route('preguntas.update', $pregunta->id),
                                            'method' => 'PUT',
                                            'buttonText' => 'Guardar Cambios'
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            @else
                <p><i class="bi bi-exclamation-triangle"></i> No hay preguntas de {{ $evaluacion }} aún.</p>
            @endif
        </div>
    </div>
@endforeach

@endsection
