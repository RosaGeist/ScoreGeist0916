@extends('layouts.menu')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h1 class="card-title">Bienvenido, {{ Auth::user()->name }}!</h1>
                    <p class="card-text">Esta es tu página principal como estudiante. Aquí encontrarás tus actividades y recursos importantes.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Notificaciones</h5>
                </div>
                <div class="card-body">
                    <p>No tienes notificaciones por el momento.</p>
                    <!-- En el futuro, puedes agregar un bucle aquí para mostrar notificaciones -->
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5>Opciones</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Ver mi perfil</li>
                    <li class="list-group-item">Mis grupos</li>
                    <li class="list-group-item">Actividades recientes</li>
                    <li class="list-group-item">Calendario</li>
                    <li class="list-group-item">Configuración</li>
                    <!-- Puedes convertir estos en enlaces cuando tengas las rutas -->
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

