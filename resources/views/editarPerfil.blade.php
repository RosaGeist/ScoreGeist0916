@extends('layouts.menu')

@section('content')
    <div class="container">
        <h1>Editar Perfil</h1>
        <form action="{{ route('perfil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $usuario->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $usuario->phone) }}">
            </div>

            {{-- @if ($usuario->rol->name == 'Estudiante')
                <div class="form-group">
                    <label for="carrera">Carrera</label>
                    <select class="form-select" id="carrera{{ $usuario->id }}" name="carrera">
                        <option value="ingenieria_informatica"
                            {{ $usuario->carrera == 'ingenieria_informatica' ? 'selected' : '' }}>
                            Ingeniería Informática
                        </option>
                        <option value="ingenieria_en_sistemas"
                            {{ $usuario->carrera == 'ingenieria_en_sistemas' ? 'selected' : '' }}>
                            Ingeniería en Sistemas
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="codigoSIS">Código SIS</label>
                    <input type="text" name="codigoSIS" class="form-control"
                        value="{{ old('codigoSIS', $usuario->codigoSIS) }}">
                </div>
            @endif --}}
            <button type="submit" class="btn btn-success">Actualizar</button>
        </form>


    </div>
@endsection
