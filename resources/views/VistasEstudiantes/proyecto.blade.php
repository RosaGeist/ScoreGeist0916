@extends('layouts.menu')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
        <li class="breadcrumb-item">{{$equipo->nombre_empresa}}</li>
        <li class="breadcrumb-item">Proyectos</li>
    </ol>
</nav>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="mb-0">Proyectos de {{ $equipo->nombre_empresa }}</h1>
  @if (Auth::id() === $equipo->creador_id)
  <button type="button" class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createProjectModal">
      <i class="bi bi-plus-circle me-2"></i> Crear Proyecto
  </button>
  @endif
</div>

  <!-- Modal -->
  <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createProjectModalLabel">Crear Proyecto</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

          <form action="{{ route('proyectos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="projectName" class="form-label">Nombre del Proyecto</label>
              <input type="text" class="form-control" id="projectName" name="nombre" required>
            </div>
  
            <div class="mb-3">
              <label for="projectDescription" class="form-label">Descripción</label>
              <textarea class="form-control" id="projectDescription" name="descripcion" rows="3" required></textarea>
            </div>
  
            <div class="mb-3">
              <label for="projectObjectives" class="form-label">Objetivos</label>
              <textarea class="form-control" id="projectObjectives" name="objetivos" rows="3" required></textarea>
            </div>
  
            <div class="mb-3">
              <label for="projectStart" class="form-label">Fecha de Inicio</label>
              <input type="date" class="form-control" id="projectStart" name="duracion_inicio" required>
            </div>
  
            <div class="mb-3">
              <label for="projectEnd" class="form-label">Fecha de Fin</label>
              <input type="date" class="form-control" id="projectEnd" name="duracion_fin" required>
            </div>
  
            <div class="mb-3">
              <label for="projectStatus" class="form-label">Estado</label>
              <select class="form-select" id="projectStatus" name="estado" required>
                <option value="planeado">Planeado</option>
                <option value="en progreso">En Progreso</option>
                <option value="finalizado">Finalizado</option>
              </select>
            </div>
  
            <!-- Campo oculto para pasar el equipo_id automáticamente -->
            <input type="hidden" name="equipo_id" value="{{ $equipo->id }}">
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Crear Proyecto</button>
        </div>
      </form>
      </div>
    </div>
  </div>
  
  <table class="table">
    <thead>
        <tr>
            <th scope="col">Nombre del Proyecto</th>
            <th scope="col">Descripción</th>
            <th scope="col">Objetivos</th>
            <th scope="col">Fecha de Inicio</th>
            <th scope="col">Fecha de Fin</th>
            <th scope="col">Estado</th>
            @if (Auth::id() === $equipo->creador_id)
            <th scope="col">Acciones</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($equipo->proyectos as $proyecto)
        <tr>
            <td>{{ $proyecto->nombre }}</td>
            <td>{{ $proyecto->descripcion }}</td>
            <td>{{ $proyecto->objetivos }}</td>
            <td>{{ $proyecto->duracion_inicio }}</td>
            <td>{{ $proyecto->duracion_fin }}</td>
            <td>{{ $proyecto->estado }}</td>
            @if (Auth::id() === $equipo->creador_id)
            <td>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProjectModal{{ $proyecto->id }}">
                    Editar
                </button>
        
                <div class="modal fade" id="editProjectModal{{ $proyecto->id }}" tabindex="-1" aria-labelledby="editProjectModalLabel{{ $proyecto->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProjectModalLabel{{ $proyecto->id }}">Editar Proyecto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('proyectos.update', $proyecto->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="projectName" class="form-label">Nombre del Proyecto</label>
                                        <input type="text" class="form-control" id="projectName" name="nombre" value="{{ $proyecto->nombre }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="projectDescription" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="projectDescription" name="descripcion" rows="3" required>{{ $proyecto->descripcion }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="projectObjectives" class="form-label">Objetivos</label>
                                        <textarea class="form-control" id="projectObjectives" name="objetivos" rows="3" required>{{ $proyecto->objetivos }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="projectStart" class="form-label">Fecha de Inicio</label>
                                        <input type="date" class="form-control" id="projectStart" name="duracion_inicio" value="{{ $proyecto->duracion_inicio }}" required readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="projectEnd" class="form-label">Fecha de Fin</label>
                                        <input type="date" class="form-control" id="projectEnd" name="duracion_fin" value="{{ $proyecto->duracion_fin }}" required readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="projectStatus" class="form-label">Estado</label>
                                        <select class="form-select" id="projectStatus" name="estado" required>
                                            <option value="planeado" {{ $proyecto->estado == 'planeado' ? 'selected' : '' }}>Planeado</option>
                                            <option value="en progreso" {{ $proyecto->estado == 'en progreso' ? 'selected' : '' }}>En Progreso</option>
                                            <option value="finalizado" {{ $proyecto->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Actualizar Proyecto</button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <form action="{{ route('proyectos.destroy', $proyecto->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

    
@endsection