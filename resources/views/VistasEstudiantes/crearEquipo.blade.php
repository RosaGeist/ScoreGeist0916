@extends('layouts.menu')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
            <li class="breadcrumb-item">Mis materias</li>
            {{-- <li class="breadcrumb-item"><a href="{{ route('grupo.mostrar', $grupo->id) }}">{{ $grupo->nombre }}</a></li> --}}
            <li class="breadcrumb-item">Crear empresa</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearEquipo">
        Crear empresa
    </button>

    @if ($errors->has('nombre_empresa'))
        <div class="alert alert-danger p-1 text-center" role="alert">
            <span>{{ $errors->first('nombre_empresa') }}</span>
        </div>
    @endif

    <div class="modal fade m-3" id="crearEquipo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="crearEquipoLabel" aria-hidden="true">
        <form method="POST" action="{{ route('equipos.store', $grupo->id) }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre_empresa" class="form-label">Nombre de la Empresa:</label>
                            <input type="text" name="nombre_empresa" id="nombre_empresa" class="form-control"
                                placeholder="Ejemplo S.A." required>

                        </div>

                        <div class="mb-3">
                            <label for="correo_empresa" class="form-label">Correo de la Empresa:</label>
                            <input type="email" name="correo_empresa" id="correo_empresa" class="form-control"
                                placeholder="contacto@ejemplo.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="link_drive" class="form-label">Link de Drive:</label>
                            <input type="url" name="link_drive" id="link_drive" class="form-control"
                                placeholder="https://drive.google.com/..." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear empresa</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @foreach ($grupo->equipos as $equipo)
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        @if (Auth::id() === $equipo->creador_id)
                        <h3 class="card-title text-center mb-0">
                            <a href="{{ route('equipos.proyectos', $equipo->id) }}">
                                {{ $equipo->nombre_empresa }}
                            </a>
                        </h3>
                        @else
                        <h3 class="card-title text-center mb-0">
                           
                                {{ $equipo->nombre_empresa }}
                            
                        </h3>
                    @endif
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
                        @endif
                    </div>
                    {{-- ACA se puede editar datos de un grupo empresa --}}
                    <div class="modal fade" id="editarEquipoModal-{{ $equipo->id }}" tabindex="-1"
                        aria-labelledby="editarEquipoLabel-{{ $equipo->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarEquipoLabel-{{ $equipo->id }}">Editar Empresa</h5>
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

                    <p class="card-text m-0"><strong>Correo:</strong> {{ $equipo->correo_empresa }}</p>
                    <p class="card-text"><strong>Link de Drive:</strong> <a href="{{ $equipo->link_drive }}"
                            target="_blank">Acceder</a></p>

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
        </div>
    @endforeach
@endsection
