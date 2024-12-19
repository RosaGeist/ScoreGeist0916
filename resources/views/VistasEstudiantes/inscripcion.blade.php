@extends('layouts.menu')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
            <li class="breadcrumb-item">Crear empresa</li>
        </ol>
    </nav>

    
    <div class="container">
        <h1>Inscripción a Grupos</h1>
        <div class="row">
            @foreach ($grupos as $grupo)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5>{{ $grupo->nombre }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $grupo->descripcion }}</p>
                            @if ($usuario->gruposAsignados()->where('grupo_id', $grupo->id)->exists())
                                <p class="alert alert-info text-center p-2">Ya estás inscrito en este grupo.</p>
                                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                    data-bs-target="#crearEmpresaModal-{{ $grupo->id }}">
                                    Crear empresa
                                </button>

                                <!-- Modal para crear empresa -->
                                <div class="modal fade" id="crearEmpresaModal-{{ $grupo->id }}" tabindex="-1"
                                    aria-labelledby="crearEmpresaLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('equipos.store', $grupo->id) }}">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="crearEmpresaLabel">Crear Empresa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="nombre_empresa" class="form-label">Nombre de la
                                                            Empresa:</label>
                                                        <input type="text" name="nombre_empresa" id="nombre_empresa"
                                                            class="form-control" placeholder="Ejemplo S.A." required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="correo_empresa" class="form-label">Correo de la
                                                            Empresa:</label>
                                                        <input type="email" name="correo_empresa" id="correo_empresa"
                                                            class="form-control" placeholder="contacto@ejemplo.com"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="link_drive" class="form-label">Link de Drive:</label>
                                                        <input type="url" name="link_drive" id="link_drive"
                                                            class="form-control" placeholder="https://drive.google.com/..."
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Crear empresa</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#inscripcionModal{{ $grupo->id }}">
                                    Unirse
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal para inscripción al grupo -->
                <div class="modal fade" id="inscripcionModal{{ $grupo->id }}" tabindex="-1"
                    aria-labelledby="inscripcionModalLabel{{ $grupo->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="inscripcionModalLabel{{ $grupo->id }}">Inscripción al grupo:
                                    {{ $grupo->nombre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('estudiante.inscripcion.registrar') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="codigo">Código del grupo:</label>
                                        <input type="text" name="codigo" class="form-control" required>
                                    </div>
                                    <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Inscribirse</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Lista de empresas asociadas -->
    <h2 class="mt-4">Empresas creadas</h2>
    @foreach ($grupo->equipos as $equipo)
        <div class="card mt-3">
            <div class="card-body">
                
                    <h3 class="card-title text-center mb-0">
                        <a href="{{ route('equipos.proyectos', $equipo->id) }}">
                            {{ $equipo->nombre_empresa }}
                        </a>
                    </h3>
                <p><strong>Correo:</strong> {{ $equipo->correo_empresa }}</p>
                <p><strong>Link de Drive:</strong> <a href="{{ $equipo->link_drive }}" target="_blank">Ver</a></p>
                @if (Auth::id() === $equipo->creador_id)
                    <div>
                        <form action="{{ route('equipo.eliminar', $equipo->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Estás seguro de que quieres eliminar esta empresa?');">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editarEquipoModal-{{ $equipo->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                    <div class="modal fade" id="editarEquipoModal-{{ $equipo->id }}" tabindex="-1"
                        aria-labelledby="editarEquipoLabel-{{ $equipo->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarEquipoLabel-{{ $equipo->id }}">Editar Empresa
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('equipo.update', $equipo->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nombre_empresa" class="form-label">Nombre de la Empresa</label>
                                            <input type="text" class="form-control" name="nombre_empresa"
                                                value="{{ $equipo->nombre_empresa }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="correo_empresa" class="form-label">Correo de la Empresa</label>
                                            <input type="email" class="form-control" name="correo_empresa"
                                                value="{{ $equipo->correo_empresa }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="link_drive" class="form-label">Link de Drive</label>
                                            <input type="url" class="form-control" name="link_drive"
                                                value="{{ $equipo->link_drive }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-12">
                    @if (Auth::id() === $equipo->creador_id)
                        <form action="{{ route('equipos.agregarMiembro', ['equipo' => $equipo->id]) }}"
                            method="POST" class="mt-3">
                            @csrf
                            <div class="mb-3 d-flex align-items-center">
                                <select class="form-select me-2" name="usuario_id" required
                                    style="width: auto; min-width: 150px;">
                                    <option selected disabled>Selecciona un estudiante</option>
                                    @foreach ($usuariosSinEquipo as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary"
                                    style="padding: 0.3rem 0.5rem;">Agregar
                                    miembro</button>
                            </div>
                        </form>
                    @endif
                    <h4 class="mt-4">Lista de Miembros</h4>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center"><i class="bi bi-person-fill"></i> Miembro</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Rol</th>
                                    @if (Auth::id() === $equipo->creador_id)
                                        <th class="text-center">Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($equipo->miembros as $miembro)
                                    <tr>
                                       <td class="text-center">
                                            <i class="bi bi-person-circle"></i> {{ $miembro->name }}
                                        </td>
                                        <td class="text-center">{{ $miembro->email }}</td>
                                        <td class="d-flex flex-row justify-content-center" >
                                            @if (Auth::id() === $equipo->creador_id)
                                                <!-- Solo mostrar formularios para asignar rol si el miembro no es el creador del equipo (Scrum Master) -->
                                                @if (Auth::id() !== $miembro->id)
                                                    <form action="{{ route('equipos.asignarRol', ['equipo' => $equipo->id]) }}" method="POST" class="d-flex align-items-center">
                                                        @csrf
                                                        <input type="hidden" name="usuario_id" value="{{ $miembro->id }}">
                                                        <select name="rol" class="form-select me-2" style="width: 200px;">
                                                            <option value="development" {{ $miembro->pivot->rol === 'development' ? 'selected' : '' }}>
                                                                Development
                                                            </option>
                                                            <option value="product_owner" {{ $miembro->pivot->rol === 'product_owner' ? 'selected' : '' }}>
                                                                Product Owner
                                                            </option>
                                                        </select>
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-check-circle"></i> Asignar
                                                        </button>
                                                    </form>
                                                @else
                                                    {{ ucfirst(str_replace('_', ' ', $miembro->pivot->rol)) }}
                                                @endif
                                            @else
                                                {{ ucfirst(str_replace('_', ' ', $miembro->pivot->rol)) }}
                                            @endif
                                        </td>
                                        
                                       
                                        @if (Auth::id() === $equipo->creador_id && Auth::id() !== $miembro->id)
                                            <td class="text-center">
                                                <form action="{{ route('equipos.eliminarMiembro', ['equipo' => $equipo->id]) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="usuario_id" value="{{ $miembro->id }}">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash3-fill"></i> Eliminar miembro
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
    @endforeach
   
@endsection
