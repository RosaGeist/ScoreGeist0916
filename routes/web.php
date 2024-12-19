<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\AvisoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ContenidoGrupoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\misTareasController;
use App\Http\Controllers\HistoriaUsuarioController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\SubtareaController;
use App\Http\Controllers\SprintPlannerController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RespuestaController;
use App\Models\Proyecto;
//-----------------------GENERAL---------------------------------------
// Login y logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');

Route::get('/', function () {
    return view('principal');
})->name('principal');

// Rutas para el restablecimiento de contraseña
Route::middleware('guest')->group(function () {
    Route::get('password/reset', [PasswordResetController::class, 'showResetRequestForm'])->name('password.request');
    Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

    //VISTA DE PERFIL
    Route::get('/perfil', [UsuarioController::class, 'showProfile'])->name('perfil.show');
    Route::get('/perfil/editar', [UsuarioController::class, 'editProfile'])->name('perfil.edit');
    Route::put('/perfil', [UsuarioController::class, 'updateProfile'])->name('perfil.update');

    //-----------------------VISTAS ADMINITRADORES---------------------------------------
    Route::get('/administrador/inicio', function () {
        return view('VistasAdmin.inicio');
    })->name('admin.dashboard');
    //CRUD Usuario
    Route::post('/register', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/listaRegistrados', [UsuarioController::class, 'lista'])->name('listaRegistrados');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    //-----------------------VISTAS DOCENTES---------------------------------------

    //Vista principal de los docentes
    Route::get('/docente/dashboard', function () {
        return view('VistasDocentes.inicio');
    })->name('docente.dashboard');

    //CRUD avisos
    Route::get('/docente/avisos', [AvisoController::class, 'index'])->name('avisos.create');
    Route::post('/docente/avisos', [AvisoController::class, 'store'])->name('avisos.store');
    Route::put('/docente/avisos-edit/{id}', [AvisoController::class, 'update'])->name('avisos.update');
    Route::delete('/docente/avisos-delete/{id}', [AvisoController::class, 'destroy'])->name('avisos.destroy');

    //CRUD grupos
    Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos.index');
    Route::post('/grupos', [GrupoController::class, 'store'])->name('grupos.store');
    Route::put('/grupos/{id}', [GrupoController::class, 'update'])->name('grupos.update');
    Route::delete('/grupos/{id}', [GrupoController::class, 'destroy'])->name('grupos.destroy');

    //Agregar y eliminar estudiantes de un grupo
    Route::post('/grupo/agregar-estudiante', [GrupoController::class, 'agregarEstudiante'])->name('grupo.agregarEstudiante');
    Route::delete('/grupo/{grupo}/eliminar-estudiante/{usuario}', [GrupoController::class, 'eliminarEstudiante'])
        ->name('grupo.eliminarEstudiante');

    //Vista por grupos (individual)
    Route::get('/grupos/{id}', [ContenidoGrupoController::class, 'show'])->name('grupos.show');
    Route::get('/grupo/{id}/avisos', [ContenidoGrupoController::class, 'avisos'])->name('grupo.avisos');


    Route::get('/grupo/{grupoId}/evaluaciones', [ContenidoGrupoController::class, 'mostrarEvaluaciones'])->name('grupo.evaluaciones');

    Route::get('/grupo/{id}/equipos', [ContenidoGrupoController::class, 'equipos'])->name('grupo.equipos');
    Route::get('/proyecto/{id}/sprints', [ContenidoGrupoController::class, 'verSprints'])->name('proyecto.sprints');





    Route::post('/sprint/{sprintId}/comentarios', [ComentarioController::class, 'storeSprintComentario'])->name('comentarios.sprint.store');
    Route::delete('/comentarios/{comentarioId}', [ComentarioController::class, 'destroySprintComentario'])->name('comentarios.sprint.destroy');

    Route::post('/subtarea/{subtareaId}/comentarios', [ComentarioController::class, 'storeSubtareaComentario'])->name('comentarios.subtarea.store');
    Route::delete('/comentarios/subtarea/{comentarioId}', [ComentarioController::class, 'destroySubtareaComentario'])->name('comentarios.subtarea.destroy');



    Route::get('/preguntas', [PreguntaController::class, 'index'])->name('preguntas.index');
    Route::post('/preguntas', [PreguntaController::class, 'store'])->name('preguntas.store');
    Route::put('/pregunta/{id}', [PreguntaController::class, 'update'])->name('preguntas.update');
    Route::delete('/pregunta/{id}', [PreguntaController::class, 'destroy'])->name('preguntas.destroy');


    //-----------------------VISTAS ESTUDIANTES---------------------------------------
    Route::get('/estudiante/dashboard', function () {
        return view('VistasEstudiantes.inicio');
    })->name('estudiante.dashboard');
    //Inscripcion a un grupo
    Route::get('/estudiante/inscripcion', [InscripcionController::class, 'inscripcion'])->name('estudiante.inscripcion');
    Route::post('/estudiante/inscripcion/registrar', [InscripcionController::class, 'registrar'])->name('estudiante.inscripcion.registrar');
    //mis materias

    Route::get('/estudiante/materia', function () {
        return view('VistasEstudiantes.materia');
    })->name('estudiante.materia');

    Route::get('/mis-tareas/sprints', [misTareasController::class, 'misTareasPorSprint'])->name('tareas.misTareasPorSprint');
    Route::put('/mis-tareas/{id}', [misTareasController::class, 'edit'])->name('tareas.edit');

    //Vista para crear equipo
    Route::get('/equipo/crear/{grupo}', [EquipoController::class, 'crear'])->name('equipo.crear');
    Route::post('/store/{grupo}', [EquipoController::class, 'store'])->name('equipos.store');
    Route::put('/equipo/{id}/editar', [EquipoController::class, 'update'])->name('equipo.update');
    Route::delete('/equipo/{id}', [EquipoController::class, 'destroy'])->name('equipo.eliminar');
    Route::post('/equipos/{equipo}/agregar-miembro', [EquipoController::class, 'agregarMiembro'])->name('equipos.agregarMiembro');
    Route::post('/equipos/{equipo}/eliminar-miembro', [EquipoController::class, 'eliminarMiembro'])->name('equipos.eliminarMiembro');
    Route::post('/equipos/{equipo}/asignar-rol', [EquipoController::class, 'asignarRol'])->name('equipos.asignarRol');

    //CRUD proyecto
    Route::get('equipos/{equipo}/proyectos', [ProyectosController::class, 'mostrarProyectos'])->name('equipos.proyectos');
    Route::post('/proyectos', [ProyectosController::class, 'store'])->name('proyectos.store');
    Route::put('/proyectos/{id}', [ProyectosController::class, 'update'])->name('proyectos.update');
    Route::delete('/proyectos/{id}', [ProyectosController::class, 'destroy'])->name('proyectos.destroy');

    //Sprint Planner
    Route::get('/sprint-planner', [SprintPlannerController::class, 'index'])
        ->middleware('auth')
        ->name('sprint-planner');
    Route::post('/sprints', [SprintPlannerController::class, 'store'])->name('sprints.store');
    Route::put('/sprints/{id}', [SprintPlannerController::class, 'update'])->name('sprints.update');
    Route::delete('/sprints/{id}', [SprintPlannerController::class, 'destroy'])->name('sprints.destroy');

    //Historia de usuario
    Route::get('/sprints/{id}', [HistoriaUsuarioController::class, 'show'])->name('historias.show');
    Route::post('/historias', [HistoriaUsuarioController::class, 'store'])->name('historias.store');
    Route::put('/historias/{id}', [HistoriaUsuarioController::class, 'update'])->name('historias.update');
    Route::delete('/historias/{id}', [HistoriaUsuarioController::class, 'destroy'])->name('historias.destroy');

    //CRUD Subtares
    Route::post('historias/{historia}/subtareas', [SubtareaController::class, 'store'])->name('subtareas.store');
    Route::put('/subtareas/{id}', [SubtareaController::class, 'update'])->name('subtareas.update');
    Route::delete('/subtareas/{id}', [SubtareaController::class, 'destroy'])->name('subtareas.destroy');



    // Ruta para mostrar el formulario de autoevaluación
    Route::get('/sprints/{sprint}/autoevaluacion', [RespuestaController::class, 'mostrarFormulario'])->name('autoevaluacion.formulario');
    Route::post('/sprints/{sprint}/guardar-respuestas', [RespuestaController::class, 'guardarRespuestas'])->name('guardar_respuestas');
    Route::post('/evaluacion/{sprint}', [RespuestaController::class, 'guardarEvaluacionPorPares'])
        ->middleware('auth')
        ->name('guardarEvaluacionPorPares');

        Route::get('/reporte/proyecto/{proyectoId}', function ($proyectoId) {
            $proyecto = Proyecto::with('sprints.historias.subtareas.comentarios', 'sprints.comentarios')->findOrFail($proyectoId);
        
            $html = '
            <html>
                <head>
                    <style>
                        body {
                            font-family: "Arial", sans-serif;
                            margin: 20px;
                            color: #333;
                            line-height: 1.6;
                            background-color: #f9f9f9;
                        }
                        h1 {
                            text-align: center;
                            color: #34495e;
                            font-size: 28px;
                            margin-bottom: 20px;
                            border-bottom: 3px solid #3498db;
                            padding-bottom: 10px;
                        }
                        h2, h3 {
                            color: #e67e22;
                            margin-top: 15px;
                        }
                        .section-title {
                            margin-top: 30px;
                            font-size: 20px;
                            color: #2980b9;
                            border-bottom: 2px solid #3498db;
                            padding-bottom: 5px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 15px;
                            background-color: #ffffff;
                            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                        }
                        table, th, td {
                            border: 1px solid #ddd;
                        }
                        th {
                            background-color: #3498db;
                            color: white;
                            padding: 10px;
                            text-align: left;
                        }
                        td {
                            padding: 10px;
                        }
                        .highlight {
                            background-color: #f1c40f;
                            padding: 5px;
                            border-radius: 5px;
                            color: #fff;
                            font-weight: bold;
                        }
                        .comment-section {
                            margin-top: 5px;
                            background-color: #ecf0f1;
                            padding: 5px;
                            border-left: 4px solid #3498db;
                            border-radius: 5px;
                        }
                        .comment-section h4 {
                            color: #2c3e50;
                       
                        }
                        p {
                            margin-bottom: 5px;
                        }
                        .info-box {
                            background-color: #ecf0f1;
                            padding: 10px;
                            margin-bottom: 15px;
                            border-radius: 5px;
                        }
                    </style>
                </head>
                <body>
                    <h1>Reporte del Proyecto: ' . $proyecto->nombre . '</h1>
                    <div class="info-box">
                        <p><strong>Descripción:</strong> ' . $proyecto->descripcion . '</p>
                    </div>';
        
            foreach ($proyecto->sprints as $sprint) {
                $html .= '<div class="section-title">Sprint: ' . $sprint->nombre . ' (' . $sprint->estado . ')</div>';
                $html .= '<p><strong>Objetivo:</strong> ' . $sprint->objetivo . '</p>';
                $html .= '<p><strong>Duración:</strong> ' . $sprint->fecha_inicio . ' - ' . $sprint->fecha_fin . '</p>';
        
                foreach ($sprint->historias as $historia) {
                    $html .= '<h3>' . $historia->titulo . ' (Estado: ' . $historia->estado . ')</h3>';
                    $html .= '<p><strong>Prioridad:</strong> <span class="highlight">' . $historia->prioridad . '</span></p>';
                    $html .= '<p><strong>Criterios de Aceptación:</strong> ' . $historia->criterios_aceptacion . '</p>';
        
                    if ($historia->subtareas->count() > 0) {
                        $html .= '<table>
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Estado</th>
                                            <th>Asignado a</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        foreach ($historia->subtareas as $subtarea) {
                            $html .= '<tr>
                                        <td>' . $subtarea->titulo . '</td>
                                        <td>' . $subtarea->estado . '</td>
                                        <td>' . ($subtarea->miembroAsignado ? $subtarea->miembroAsignado->name : 'N/A') . '</td>
                                      </tr>';
                            
                            // Comentarios de la subtarea
                            if ($subtarea->comentarios->count() > 0) {
                                $html .= '<tr>
                                            <td colspan="3">
                                                <div class="comment-section">
                                                    <h4>Comentarios de la subtarea</h4>';
                                foreach ($subtarea->comentarios as $comentario) {
                                    $html .= '<p><strong>' . $comentario->docente->name . ':</strong> ' . $comentario->contenido . '</p>';
                                }
                                $html .= '</div>
                                            </td>
                                          </tr>';
                            }
                        }
                        $html .= '</tbody></table>';
                    } else {
                        $html .= '<p>No hay subtareas asignadas a esta historia de usuario.</p>';
                    }
                }
        
                if ($sprint->comentarios->count() > 0) {
                    $html .= '<div class="comment-section">
                                <h4>Comentarios del Sprint</h4>';
                    foreach ($sprint->comentarios as $comentario) {
                        $html .= '<p><strong>' . $comentario->docente->name . ':</strong> ' . $comentario->contenido . '</p>';
                    }
                    $html .= '</div>';
                } else {
                    $html .= '<p>No hay comentarios para este sprint.</p>';
                }
            }
        
            $html .= '</body></html>';
        
            $pdf = PDF::loadHTML($html);
        
            return $pdf->download('reporte_proyecto.pdf');
        })->name('reporte.proyecto');
        
    Route::get('/grupo/{id}', [MateriaController::class, 'mostrar'])->name('grupo.mostrar');
    Route::get('/grupo/menu/{id}', [MateriaController::class, 'materia'])->name('grupo.menu');
});
