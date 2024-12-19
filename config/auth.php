<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'usuarios',
    ],

    'docente' => [
        'driver' => 'session',
        'provider' => 'docentes',
    ],
],


    
    'providers' => [
    'usuarios' => [
        'driver' => 'eloquent',
        'model' => App\Models\Usuario::class,
    ],

    'docentes' => [
        'driver' => 'eloquent',
        'model' => App\Models\Docente::class, // El modelo que representa a los docentes
    ],
],


    'passwords' => [
        'users' => [
            'provider' => 'usuarios', // Cambia 'users' por 'usuarios' aquí
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
