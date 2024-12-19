@extends('layouts.menu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card profile-card" style="border-radius: 16px; box-shadow: var(--shadow);">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="profile-avatar">
                            <i class="bi bi-person-circle" style="font-size: 60px; color: var(--primary-color);"></i>
                        </div>
                        <h2 class="mt-3">{{ $usuario->name }}</h2>
                    </div>
                    
                    <div class="profile-info">
                        <div class="info-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="bi bi-envelope"></i>
                                <h6 style="margin: 0;">Correo Electrónico: </h6>
                                <p style="margin: 0;">{{ $usuario->email }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="bi bi-telephone"></i>
                                <h6 style="margin: 0;">Teléfono:</h6>
                                <p style="margin: 0;">{{ $usuario->phone ? $usuario->phone : 'No registrado' }}</p>
                            </div>
                        </div>
                        
                     @if($usuario->rol->name == 'Estudiante')
                        <div class="info-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="bi bi-person-badge"></i> <!-- Ícono de código SIS -->
                                <h6 style="margin: 0;">Código SIS: </h6>
                                <p style="margin: 0;">{{ $usuario->codigoSIS ? $usuario->codigoSIS : 'No registrado' }}</p>
                            </div>
                        </div>
                
                        <div class="info-item">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="bi bi-briefcase"></i> <!-- Ícono de carrera -->
                                <h6 style="margin: 0;">Carrera: </h6>
                                <p style="margin: 0;">
                                    @if($usuario->carrera)
                                        @if($usuario->carrera == 'ingenieria_informatica')
                                            Ingeniería Informática
                                        @elseif($usuario->carrera == 'ingenieria_en_sistemas')
                                            Ingeniería en Sistemas
                                        @else
                                            {{ $usuario->carrera }}
                                        @endif
                                    @else
                                        No registrado
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                    

                    <div class="text-center mt-4">
                        <a href="{{ route('perfil.edit') }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Editar Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
