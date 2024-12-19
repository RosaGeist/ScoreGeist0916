@extends('layouts.menu')

@section('content')
    <div class="container">
        <h1>Publicar un Aviso</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearAviso">
            Crear nuevo aviso
        </button>

        <div class="modal fade" id="crearAviso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="crearAvisoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="crearAvisoLabel">Nuevo aviso</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('avisos.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="grupo_id">Grupo</label>
                                <select name="grupo_id" id="grupo_id" class="form-control" required>
                                    <option value="">Seleccione un grupo</option>
                                    @foreach ($grupos as $grupo)
                                        <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="titulo">Título del Aviso</label>
                                <input type="text" name="titulo" class="form-control" id="titulo" required>
                            </div>

                            <div class="form-group">
                                <label for="contenido">Contenido del Aviso</label>
                                <textarea name="contenido" class="form-control" id="contenido" rows="5" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Publicar Aviso</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($avisos as $aviso)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $aviso->titulo }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Grupo: {{ $aviso->grupo->nombre }}</h6>
                            <p class="card-text">{{ $aviso->contenido }}</p>
                            <p class="text-muted"><small>Publicado el: {{ $aviso->created_at->format('d/m/Y') }}</small></p>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editarAvisos{{ $aviso->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('avisos.destroy', $aviso->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Está seguro de eliminar este aviso?')"><i
                                        class="bi bi-trash3"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editarAvisos{{ $aviso->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarAvisos{{ $aviso->id }}Label"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editarAvisos{{ $aviso->id }}Label">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('avisos.update', $aviso->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')


                                    <div class="form-group">
                                        <label for="grupo_id">Grupo</label>
                                        <select name="grupo_id" class="form-control" required>
                                            @foreach ($grupos as $grupo)
                                                <option value="{{ $grupo->id }}"
                                                    {{ $grupo->id == $aviso->grupo_id ? 'selected' : '' }}>
                                                    {{ $grupo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="titulo">Título del Aviso</label>
                                        <input type="text" name="titulo" class="form-control"
                                            value="{{ $aviso->titulo }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="contenido">Contenido del Aviso</label>
                                        <textarea name="contenido" class="form-control" rows="5" required>{{ $aviso->contenido }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
