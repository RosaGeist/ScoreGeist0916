@extends('layouts.menu')

@section('content')



    <div class="container">
        <h1>Evaluaciones del Grupo: {{ $grupo->nombre }}</h1>

        <h2>Autoevaluaciones</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($respuestasAutoevaluacion as $respuesta)
                    <tr>
                        <td>{{ $respuesta->usuario->name }}</td>
                        <td>{{ $respuesta->pregunta->texto }}</td>
                        <td>{{ $respuesta->respuesta }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Evaluaciones Cruzadas</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Evaluador</th>
                    <th>Evaluado</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($respuestasCruzadas as $respuesta)
                    <tr>
                        <td>{{ $respuesta->usuario->name }}</td>
                        <td>{{ $respuesta->evaluado->name }}</td>
                        <td>{{ $respuesta->pregunta->texto }}</td>
                        <td>{{ $respuesta->respuesta }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@include('layouts.barraBaja')
@endsection