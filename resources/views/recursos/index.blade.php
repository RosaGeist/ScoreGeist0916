<!-- resources/views/recursos/index.blade.php -->
@extends('layouts.menu')

@section('content')
    <h1>Subir Recursos</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('recursos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="recurso" class="form-label">Seleccionar Recurso</label>
            <input type="file" class="form-control" id="recurso" name="recurso" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir Recurso</button>
    </form>
@endsection
