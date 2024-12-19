@extends('layouts.menu')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
            <li class="breadcrumb-item"><a href="/sprint-planner">Sprint Planner</a></li>
        </ol>
    </nav>
    <div class="container">
        <h1>Mis Proyectos y Sprints</h1>

        @if ($proyectos->isEmpty())
            <p>No tienes proyectos asignados.</p>
        @else
            @foreach ($proyectos as $proyecto)
                <div class="card my-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $proyecto->nombre }}</h3>
                        @if (Auth::id() === $proyecto->equipo->creador_id)
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#crearSprintModal" onclick="setProyectoId({{ $proyecto->id }})">
                                Crear Sprint
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">{{ $proyecto->descripcion }}</p>
                    </div>
                </div>

                <div class="card-body">
                    @if ($proyecto->sprints->isEmpty())
                        <p>No hay sprints disponibles para este proyecto.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sprint</th>
                                    <th class="col-fecha">Fecha de Inicio</th>
                                    <th class="col-fecha">Fecha de Fin</th>
                                    <th>Duración (días)</th>
                                    @if (Auth::id() === $proyecto->equipo->creador_id)
                                        <th>Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proyecto->sprints as $index => $sprint)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div>
                                                <a href="{{ route('historias.show', $sprint->id) }}"
                                                    class="text-decoration-none">
                                                    {{ $sprint->nombre }}
                                                </a>
                                                @if ($sprint->estado == 'Pendiente')
                                                    <span class="badge text-bg-primary">{{ $sprint->estado }}</span>
                                                @elseif($sprint->estado == 'En Proceso')
                                                    <span class="badge text-bg-secondary">{{ $sprint->estado }}</span>
                                                @elseif($sprint->estado == 'Completado')
                                                    <span class="badge text-bg-success">{{ $sprint->estado }}</span>
                                                    <a href="{{ route('autoevaluacion.formulario', $sprint->id) }}"
                                                        class="btn btn-success">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div><strong>Objetivo:</strong> {{ $sprint->objetivo }}</div>
                                        </td>
                                        <td class="col-fecha">{{ $sprint->fecha_inicio }}</td>
                                        <td class="col-fecha">{{ $sprint->fecha_fin }}</td>
                                        <td>
                                            @php
                                                $fecha_inicio = \Carbon\Carbon::parse($sprint->fecha_inicio);
                                                $fecha_fin = \Carbon\Carbon::parse($sprint->fecha_fin);
                                                $duracion = $fecha_inicio->diffInDays($fecha_fin);
                                            @endphp
                                            {{ $duracion }} días
                                        </td>
                                        @if (Auth::id() === $proyecto->equipo->creador_id)
                                            <td>
                                                <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este sprint?');">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editarSprintModal-{{ $sprint->id }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <div class="modal fade" id="editarSprintModal-{{ $sprint->id }}"
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
                                                                <form action="{{ route('sprints.update', $sprint->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <!-- Campo de Nombre -->
                                                                    <div class="mb-3">
                                                                        <label for="nombre"
                                                                            class="form-label text-start">Nombre del
                                                                            Sprint</label>
                                                                        <input type="text" class="form-control"
                                                                            name="nombre" value="{{ $sprint->nombre }}"
                                                                            required>
                                                                    </div>

                                                                    <!-- Campo de Objetivo -->
                                                                    <div class="mb-3">
                                                                        <label for="objetivo"
                                                                            class="form-label text-start">Objetivo del
                                                                            Sprint</label>
                                                                        <textarea class="form-control" name="objetivo" required>{{ $sprint->objetivo }}</textarea>
                                                                    </div>

                                                                    <!-- Campo de Fecha de Inicio -->
                                                                    <div class="mb-3">
                                                                        <label for="fecha_inicio"
                                                                            class="form-label text-start">Fecha de
                                                                            Inicio</label>
                                                                        <input type="date" class="form-control"
                                                                            name="fecha_inicio"
                                                                            value="{{ $sprint->fecha_inicio }}" required>
                                                                    </div>

                                                                    <!-- Campo de Fecha de Fin -->
                                                                    <div class="mb-3">
                                                                        <label for="fecha_fin"
                                                                            class="form-label text-start">Fecha de
                                                                            Fin</label>
                                                                        <input type="date" class="form-control"
                                                                            name="fecha_fin"
                                                                            value="{{ $sprint->fecha_fin }}" required>
                                                                    </div>

                                                                    <!-- Campo de Estado del Sprint -->
                                                                    <div class="mb-3">
                                                                        <label for="estado"
                                                                            class="form-label text-start">Estado del
                                                                            Sprint</label>
                                                                        <select class="form-control" name="estado"
                                                                            required>
                                                                            <option value="Pendiente"
                                                                                {{ $sprint->estado == 'Pendiente' ? 'selected' : '' }}>
                                                                                Pendiente</option>
                                                                            <option value="En Proceso"
                                                                                {{ $sprint->estado == 'En Proceso' ? 'selected' : '' }}>
                                                                                En Proceso</option>
                                                                            <option value="Completado"
                                                                                {{ $sprint->estado == 'Completado' ? 'selected' : '' }}>
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
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
    </div>
    @endforeach
    <div class="modal fade" id="crearSprintModal" tabindex="-1" aria-labelledby="crearSprintModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearSprintModalLabel">Crear Sprint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sprints.store') }}" method="POST">
                        @csrf
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
    @endif
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

@endsection
