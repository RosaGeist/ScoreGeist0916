@extends('layouts.menu')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/docente/dashboard">Página principal</a></li>
            <li class="breadcrumb-item"><a href="/grupos">Grupos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('grupo.avisos', $grupo->id) }}">{{ $grupo->nombre }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('grupo.equipos', $grupo->id) }}"> Equipos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('proyecto.sprints', $proyecto->id) }}">
                    {{ $proyecto->nombre }}</a></li>
        </ol>
    </nav>
    <div class="container">
        <h1 class="d-flex justify-content-between align-items-center">
            Proyecto: {{ $proyecto->nombre }}
            <a href="{{ route('reporte.proyecto', $proyecto->id) }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-text"></i> Generar Reporte
            </a>
        </h1>

        <p><strong>Descripción:</strong> {{ $proyecto->descripcion }}</p>

        <h2>Sprints</h2>
        @if ($proyecto->sprints->isNotEmpty())
            <div class="row">
                @foreach ($proyecto->sprints as $index => $sprint)
                    <div class="col-md-12 col-lg-12 mx-auto mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                <h5>{{ $sprint->nombre }} ({{ $sprint->estado }})</h5>
                            </div>
                            <div class="card-body">
                                <!-- Información del sprint -->
                                <div class="d-flex justify-content-between">
                                    <div>

                                        <p><strong>Objetivo:</strong> {{ $sprint->objetivo }}</p>
                                    </div>
                                    <div>

                                        <p><strong>Duración:</strong> Inicio: {{ $sprint->fecha_inicio }} - Fin:
                                            {{ $sprint->fecha_fin }}</p>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                  
                                    <div class="col-md-12">
                                        <h4 class="mb-4">Historias de Usuario:</h4>
                                        @if ($sprint->historias->isNotEmpty())
                                            @foreach ($sprint->historias as $historia)
                                                <div class="card mb-4 shadow-sm border-0">
                                                    <!-- Card Header con fondo de color -->
                                                    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #007bff;">
                                                        <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>Historia de Usuario: {{ $historia->titulo }}</h5>
                                                        <span class="badge bg-light text-dark">{{ $historia->estado }}</span>
                                                    </div>
                                    
                                                    <!-- Card Body -->
                                                    <div class="card-body">
                                                        <p><strong><i class="bi bi-info-circle me-2"></i>Descripción:</strong> {{ $historia->descripcion }}</p>
                                                        <div class="d-flex justify-content-between mt-3">
                                                            <div><i class="bi bi-flag-fill text-danger me-2"></i><strong>Prioridad:</strong> {{ $historia->prioridad }}</div>
                                                        </div>
                                                        <h6 class="mt-4"><strong><i class="bi bi-check-circle-fill text-success me-2"></i>Criterios de Aceptación:</strong></h6>
                                                        <p>{{ $historia->criterios_aceptacion }}</p>
                                                    </div>
                                    
                                                    <!-- Subtareas -->
                                                    <div class="card-footer bg-light">
                                                        <h6><i class="bi bi-list-task me-2"></i>Subtareas:</h6>
                                                        @if ($historia->subtareas->isNotEmpty())
                                                            @foreach ($historia->subtareas as $subtarea)
                                                                <div class="card mb-3 border-0 shadow-sm">
                                                                    <div class="card-body">
                                                                        <strong><i class="bi bi-chevron-right"></i> {{ $subtarea->titulo }}:</strong> {{ $subtarea->descripcion }}
                                                                        <span class="badge bg-info ms-2">{{ $subtarea->estado }}</span>
                                                                        @if ($subtarea->miembroAsignado)
                                                                            <br><i class="bi bi-person-fill me-2"></i><strong>Asignado a:</strong> {{ $subtarea->miembroAsignado->name }}
                                                                        @endif
                                                                    </div>
                                    
                                                                    <!-- Comentarios de Subtarea -->
                                                                    <div class="card-footer bg-white">
                                                                        <h6><i class="bi bi-chat-left-text-fill me-2"></i>Comentarios:</h6>
                                                                        @if ($subtarea->comentarios->isNotEmpty())
                                                                            @foreach ($subtarea->comentarios as $comentario)
                                                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                                                    <p class="mb-0">
                                                                                        <strong>{{ $comentario->docente->name }}</strong>: {{ $comentario->contenido }}
                                                                                    </p>
                                                                                    <form action="{{ route('comentarios.subtarea.destroy', $comentario->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este comentario?')">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                                            <i class="bi bi-trash-fill"></i>
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <p>No hay comentarios para esta subtarea.</p>
                                                                        @endif
                                    
                                                                        <!-- Formulario para agregar comentario -->
                                                                        <div class="row mt-3">
                                                                            <form action="{{ route('comentarios.subtarea.store', $subtarea->id) }}" method="POST">
                                                                                @csrf
                                                                                <div class="input-group">
                                                                                    <textarea class="form-control" name="contenido" rows="1" placeholder="Escribe tu comentario..."></textarea>
                                                                                    <button type="submit" class="btn btn-success">
                                                                                        <i class="bi bi-send-fill"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p>No hay subtareas para esta historia.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                    
                                            <!-- Comentarios del Sprint -->
                                            <div class="card mt-4 shadow-sm border-0">
                                                <div class="card-header bg-secondary text-white">
                                                    <h5><i class="bi bi-chat-dots me-2"></i>Comentarios del Sprint</h5>
                                                </div>
                                                <div class="card-body">
                                                    @if ($sprint->comentarios->isNotEmpty())
                                                        @foreach ($sprint->comentarios as $comentario)
                                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                                <p class="mb-0"><strong>{{ $comentario->docente->name }}</strong>: {{ $comentario->contenido }}</p>
                                                                <form action="{{ route('comentarios.sprint.destroy', $comentario->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este comentario?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p>No hay comentarios para este sprint.</p>
                                                    @endif
                                    
                                                    <!-- Formulario para agregar comentario -->
                                                    <div class="row mt-3">
                                                        <form action="{{ route('comentarios.sprint.store', $sprint->id) }}" method="POST">
                                                            @csrf
                                                            <div class="input-group">
                                                                <textarea class="form-control" name="contenido" rows="1" placeholder="Escribe tu comentario..."></textarea>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="bi bi-send-fill"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <p>No hay historias de usuario para este sprint.</p>
                                        @endif
                                    </div>
                                    


                                </div>


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No hay sprints registrados para este proyecto.</p>
        @endif
    </div>



    @include('layouts.barraBaja')
@endsection
