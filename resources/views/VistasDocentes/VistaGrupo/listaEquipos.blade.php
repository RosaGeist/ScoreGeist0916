@extends('layouts.menu')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/docente/dashboard">Página principal</a></li>
        <li class="breadcrumb-item"><a href="/grupos">Grupos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('grupo.avisos', $grupo->id) }}">{{ $grupo->nombre }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('grupo.equipos', $grupo->id) }}"> Equipos</a></li>
    </ol>
</nav>
<h1>Equipos</h1>

@foreach ($grupo->equipos as $equipo)
    <h3>Equipo: {{ $equipo->nombre_empresa }}</h3>

    <h4>Miembros:</h4>
    <ul>
        @foreach ($equipo->miembros as $miembro)
            <li>{{ $miembro->name }} ({{ $miembro->email }})</li>
        @endforeach
    </ul>

    <h4>Proyectos:</h4>
    @if ($equipo->proyectos->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Objetivos</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
               
                </tr>
            </thead>
            <tbody>
                @foreach ($equipo->proyectos as $proyecto)
                    <tr>
                        <td><a href="{{ route('proyecto.sprints', $proyecto->id) }}">
                            {{ $proyecto->nombre }}
                        </a></td>
                        <td>{{ $proyecto->descripcion }}</td>
                        <td>{{ $proyecto->objetivos }}</td>
                        <td>{{ $proyecto->duracion_inicio }}</td>
                        <td>{{ $proyecto->duracion_fin }}</td>
                        <td>{{ $proyecto->estado }}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay proyectos registrados para este equipo.</p>
    @endif
@endforeach


@include('layouts.barraBaja')
@endsection