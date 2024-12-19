@extends('layouts.menu')

@section('content')
    <h1>Contenido de la Materia</h1>
    <p>Aquí puedes agregar el contenido de la materia.</p>

    @if($recursos->isEmpty())
        <p>No se han subido recursos aún.</p>
    @else
        <ul class="list-group">
            @foreach($recursos as $recurso)
                <li class="list-group-item">
                    <a href="{{ asset('storage/' . $recurso->ruta) }}" target="_blank">{{ $recurso->nombre }}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection