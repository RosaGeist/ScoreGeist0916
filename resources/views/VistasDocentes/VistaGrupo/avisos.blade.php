@extends('layouts.menu')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/docente/dashboard">Página principal</a></li>
        <li class="breadcrumb-item"><a href="/grupos">Grupos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('grupo.avisos', $grupo->id) }}">{{ $grupo->nombre }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('grupo.avisos', $grupo->id) }}"> Novedades</a></li>
    </ol>
</nav>
<div class="container">
    <h1>Novedades de {{ $grupo->nombre }}</h1>
    <ul class="list-group">
        @forelse ($grupo->avisos as $aviso)
            <li class="list-group-item">{{ $aviso->titulo }} - {{ $aviso->contenido }}</li>
        @empty
            <li class="list-group-item">No hay novedades.</li>
        @endforelse
    </ul>
</div>
@include('layouts.barraBaja')
@endsection