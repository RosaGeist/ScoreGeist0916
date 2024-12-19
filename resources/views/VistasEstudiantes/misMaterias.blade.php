@extends('layouts.menu')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/estudiante/dashboard">Página principal</a></li>
        <li class="breadcrumb-item">Mis materias</li>
        <li class="breadcrumb-item"><a href="{{ route('grupo.mostrar', $grupo->id) }}">{{ $grupo->nombre }}</a></li>
    </ol>
</nav>
    <h1 class="text-center">{{ $grupo->nombre }}</h1>
    <div class="border p-3">
        Descripción: {{ $grupo->descripcion }}
    </div>
    
    <h5>
        <a href="{{ route('equipo.crear', $grupo->id) }}" style="text-decoration: none">
            <i class="bi bi-people-fill"></i> Crear equipos
        </a>
    </h5>
   
@endsection
