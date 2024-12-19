@extends('layouts.menu')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
            <li class="breadcrumb-item"><a href="/sprint-planner">Sprint Planner</a></li>
            <li class="breadcrumb-item"><a href="{{ route('historias.show', $sprint->id) }}">{{ $sprint->nombre }}</a></li>

        </ol>
    </nav>
    <div class="container">
        <h1 class="d-flex justify-content-between align-items-center">
            Sprint: {{ $sprint->nombre }}
            @if (Auth::id() === $sprint->proyecto->equipo->creador_id)
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                    data-bs-target="#crearHistoriaModal">
                    <i class="bi bi-plus-circle"></i> Crear Historia de Usuario
                </button>
            @endif
        </h1>

        <div class="card">
            <div class="card-body p-3">
                <p class="mb-2"><strong>Proyecto:</strong> {{ $sprint->proyecto->nombre }}</p>
                <p class="mb-2"><strong>Objetivo:</strong> {{ $sprint->objetivo }}</p>
                <div class="d-flex justify-content-between mb-2">
                    <p class="mb-0"><strong>Fecha de Inicio:</strong>
                        {{ \Carbon\Carbon::parse($sprint->fecha_inicio)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                    </p>
                    <p class="mb-0"><strong>Fecha de Fin:</strong>
                        {{ \Carbon\Carbon::parse($sprint->fecha_fin)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                    </p>
                </div>
                <hr>
                <p class="mb-2"><strong>Comentarios:</strong></p>
                @forelse ($sprint->comentarios as $comentario)
                    <p class="mb-2"><strong>{{ $comentario->docente->name }}</strong>: {{ $comentario->contenido }}</p>
                @empty
                    <p>No hay comentarios.</p>
                @endforelse
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
                        <form action="{{ route('historias.store') }}" method="POST">
                            @csrf
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
                            <input type="hidden" name="sprints_id" value="{{ $sprint->id }}">
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
            @if ($sprint->historias->isEmpty())
                <p>No hay historias de usuario para este sprint.</p>
            @else
                @foreach ($sprint->historias as $historia)
                    <div class="card mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #5CCFCF;">
                            <div>
                                <h4 class="mb-0">H.U. {{ $historia->titulo }}</h4>
                                <span class="badge bg-primary">Prioridad: {{ $historia->prioridad }}</span>
                                <span class="badge bg-{{ $historia->estado == 'completado' ? 'success' : 'warning' }}">
                                    Estado: {{ ucfirst($historia->estado) }}
                                </span>
                            </div>
                            @if (Auth::id() === $sprint->proyecto->equipo->creador_id)
                                <div>

                                    <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                        data-bs-target="#editarHistoriaModal{{ $historia->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>


                                    <div class="modal fade" id="editarHistoriaModal{{ $historia->id }}" tabindex="-1"
                                        aria-labelledby="editarHistoriaModalLabel{{ $historia->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editarHistoriaModalLabel{{ $historia->id }}">Editar Historia
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('historias.update', $historia->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="titulo" class="form-label">Título</label>
                                                            <input type="text" class="form-control" id="titulo"
                                                                name="titulo" value="{{ $historia->titulo }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="descripcion"
                                                                class="form-label">Descripción</label>
                                                            <textarea class="form-control" id="descripcion" name="descripcion" required>{{ $historia->descripcion }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="prioridad" class="form-label">Prioridad</label>
                                                            <select class="form-control" id="prioridad" name="prioridad"
                                                                required>
                                                                <option value="Alta"
                                                                    {{ $historia->prioridad == 'Alta' ? 'selected' : '' }}>
                                                                    Alta</option>
                                                                <option value="Media"
                                                                    {{ $historia->prioridad == 'Media' ? 'selected' : '' }}>
                                                                    Media</option>
                                                                <option value="Baja"
                                                                    {{ $historia->prioridad == 'Baja' ? 'selected' : '' }}>
                                                                    Baja</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="estado" class="form-label">Estado</label>
                                                            <select class="form-control" id="estado" name="estado"
                                                                required>
                                                                <option value="pendiente"
                                                                    {{ $historia->estado == 'pendiente' ? 'selected' : '' }}>
                                                                    Pendiente</option>
                                                                <option value="en progreso"
                                                                    {{ $historia->estado == 'en progreso' ? 'selected' : '' }}>
                                                                    En Progreso</option>
                                                                <option value="completado"
                                                                    {{ $historia->estado == 'completado' ? 'selected' : '' }}>
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

                                    <form action="{{ route('historias.destroy', $historia->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger text-white"
                                            onclick="return confirm('¿Estás seguro de eliminar esta historia?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <p><strong>Descripción:</strong> {{ $historia->descripcion }}</p>
                            <p><strong>Criterios de Aceptación:</strong> {{ $historia->criterios_aceptacion }}</p>

                           

                            <div class="d-flex justify-content-between align-items-center">
                                <h2>Subtareas</h2>
                                @if (Auth::id() === $sprint->proyecto->equipo->creador_id)
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modalSubtarea{{ $historia->id }}">
                                        <i class="bi bi-plus-circle"></i> Agregar Subtarea
                                    </button>
                                @endif
                            </div>

                            <div class="modal fade" id="modalSubtarea{{ $historia->id }}" tabindex="-1"
                                aria-labelledby="modalSubtareaLabel{{ $historia->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalSubtareaLabel{{ $historia->id }}">Crear
                                                Subtarea
                                                para: {{ $historia->titulo }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('subtareas.store', $historia->id) }}" method="POST">
                                                @csrf
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
                                                        @foreach ($miembros as $miembro)
                                                            <option value="{{ $miembro->id }}">{{ $miembro->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-success">Guardar Subtarea</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($historia->subtareas->isEmpty())
                                <p>No hay subtareas asignadas.</p>
                            @else
                                @foreach ($historia->subtareas as $subtarea)
                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-md-10">
                                                <h4 class="mb-0">{{ $subtarea->titulo }}</h4>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-dark p-0" type="button"
                                                        id="dropdownMenuButton{{ $subtarea->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-list" style="font-size: 24px; color: black;"></i>
                                                    </button>

                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton{{ $subtarea->id }}">
                                                        @if (Auth::id() === $sprint->proyecto->equipo->creador_id)
                                                            <li>

                                                                <form
                                                                    action="{{ route('subtareas.destroy', $subtarea->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-dark"
                                                                        style="color: black; font-weight: normal;"
                                                                        onclick="return confirm('¿Estás seguro de eliminar esta subtarea?')">
                                                                        <i class="bi bi-trash" style="color: red;"></i>
                                                                        Eliminar
                                                                    </button>

                                                                </form>
                                                            </li>
                                                        @endif

                                                        <li>
                                                            <button type="button" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editarSubtareaModal{{ $subtarea->id }}" style="color: black; font-weight: normal;">
                                                                @if (Auth::id() === $sprint->proyecto->equipo->creador_id)
                                                                    <i class="bi bi-pencil" style="color: rgb(255, 238, 0)";></i> Editar
                                                                @else
                                                                    <i class="bi bi-pencil" style="color:  rgb(255, 238, 0)";></";></i> Editar estado
                                                                @endif
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <strong>Descripción:</strong> {{ $subtarea->descripcion }} <br>
                                        <strong>Asignado a:</strong>
                                        {{ $subtarea->miembroAsignado ? $subtarea->miembroAsignado->name : 'Sin asignar' }}
                                        <br>

                                        <!-- Estado con Badge -->
                                        <strong>Estado:</strong>
                                        @if ($subtarea->estado == 'Pendiente')
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        @elseif ($subtarea->estado == 'En Progreso')
                                            <span class="badge bg-primary">En Progreso</span>
                                        @else
                                            <span class="badge bg-success">Completada</span>
                                        @endif
                                    </div>

                                    <div class="modal fade" id="editarSubtareaModal{{ $subtarea->id }}" tabindex="-1"
                                        aria-labelledby="editarSubtareaModalLabel{{ $subtarea->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editarSubtareaModalLabel{{ $subtarea->id }}">
                                                        @if (Auth::id() === $sprint->proyecto->equipo->creador_id)
                                                            Editar Subtarea: {{ $subtarea->titulo }}
                                                        @else
                                                            Editar estado de: {{ $subtarea->titulo }}
                                                        @endif
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('subtareas.update', $subtarea->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Título de la Subtarea (solo editable por el creador) -->
                                                        @if (Auth::id() === $sprint->proyecto->equipo->creador_id)
                                                            <div class="mb-3">
                                                                <label for="titulo" class="form-label">Título de la
                                                                    Subtarea</label>
                                                                <input type="text" class="form-control" id="titulo"
                                                                    name="titulo" value="{{ $subtarea->titulo }}"
                                                                    required>
                                                            </div>
                                                        @else
                                                            <div class="mb-3">
                                                                <label for="titulo" class="form-label">Título de la
                                                                    Subtarea</label>
                                                                <input type="text" class="form-control" id="titulo"
                                                                    name="titulo" value="{{ $subtarea->titulo }}"
                                                                    disabled>
                                                                <!-- Campo oculto para el título -->
                                                                <input type="hidden" name="titulo"
                                                                    value="{{ $subtarea->titulo }}">
                                                            </div>
                                                        @endif

                                                        <!-- Descripción (solo editable por el creador) -->
                                                        @if (Auth::id() === $sprint->proyecto->equipo->creador_id)
                                                            <div class="mb-3">
                                                                <label for="descripcion"
                                                                    class="form-label">Descripción</label>
                                                                <textarea class="form-control" id="descripcion" name="descripcion" required>{{ $subtarea->descripcion }}</textarea>
                                                            </div>
                                                        @else
                                                            <div class="mb-3">
                                                                <label for="descripcion"
                                                                    class="form-label">Descripción</label>
                                                                <textarea class="form-control" id="descripcion" name="descripcion" disabled>{{ $subtarea->descripcion }}</textarea>
                                                                <!-- Campo oculto para la descripción -->
                                                                <input type="hidden" name="descripcion"
                                                                    value="{{ $subtarea->descripcion }}">
                                                            </div>
                                                        @endif

                                                        <!-- Estado (siempre editable) -->
                                                        <div class="mb-3">
                                                            <label for="estado" class="form-label">Estado</label>
                                                            <select class="form-control" id="estado" name="estado"
                                                                required>
                                                                <option value="Pendiente"
                                                                    {{ $subtarea->estado == 'Pendiente' ? 'selected' : '' }}>
                                                                    Pendiente</option>
                                                                <option value="En Progreso"
                                                                    {{ $subtarea->estado == 'En Progreso' ? 'selected' : '' }}>
                                                                    En Progreso</option>
                                                                <option value="Completada"
                                                                    {{ $subtarea->estado == 'Completada' ? 'selected' : '' }}>
                                                                    Completada</option>
                                                            </select>
                                                        </div>

                                                        <!-- Miembro Asignado (solo editable por el creador) -->
                                                        @if (Auth::id() === $sprint->proyecto->equipo->creador_id)
                                                            <div class="mb-3">
                                                                <label for="miembro_asignado" class="form-label">Miembro
                                                                    Asignado</label>
                                                                <select class="form-control" id="miembro_asignado"
                                                                    name="miembro_asignado">
                                                                    <option value="">Seleccionar Miembro</option>
                                                                    @foreach ($miembros as $miembro)
                                                                        <option value="{{ $miembro->id }}"
                                                                            {{ $subtarea->miembroAsignado && $subtarea->miembroAsignado->id == $miembro->id ? 'selected' : '' }}>
                                                                            {{ $miembro->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @else
                                                            <div class="mb-3">
                                                                <label for="miembro_asignado" class="form-label">Miembro
                                                                    Asignado</label>
                                                                <input type="text" class="form-control"
                                                                    id="miembro_asignado"
                                                                    value="{{ $subtarea->miembroAsignado ? $subtarea->miembroAsignado->name : 'Ninguno' }}"
                                                                    disabled>
                                                                <!-- Campo oculto para el miembro asignado -->
                                                                <input type="hidden" name="miembro_asignado"
                                                                    value="{{ $subtarea->miembroAsignado ? $subtarea->miembroAsignado->id : '' }}">
                                                            </div>
                                                        @endif

                                                        <button type="submit" class="btn btn-success">
                                                            Actualizar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
@endsection
