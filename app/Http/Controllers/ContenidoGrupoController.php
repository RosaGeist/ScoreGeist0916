<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Proyecto;
use App\Models\Respuesta;
use App\Models\RespuestaPorPares;
class ContenidoGrupoController extends Controller
{

    public function avisos($id)
    {
        $grupo = Grupo::with('avisos')->findOrFail($id);
        return view('VistasDocentes.VistaGrupo.avisos', compact('grupo'));
    }

    public function equipos($id)
    {
        $grupo = Grupo::with(['equipos.miembros', 'equipos.proyectos'])->findOrFail($id);
        return view('VistasDocentes.VistaGrupo.listaEquipos', compact('grupo'));
    }

    public function verSprints($id)
    {
        $proyecto = Proyecto::with('sprints')->findOrFail($id);
        $grupo = $proyecto->equipo->grupo; // Asegúrate de que las relaciones estén bien definidas
        return view('VistasDocentes.VistaGrupo.verSprints', compact('proyecto', 'grupo'));
    }

    public function mostrarEvaluaciones($grupoId)
{
    // Obtener todos los usuarios del grupo
    $grupo = Grupo::with(['usuarios'])->findOrFail($grupoId);
    
    // Obtener las respuestas de los usuarios (autoevaluaciones y cruzadas)
    $respuestasAutoevaluacion = Respuesta::with(['pregunta', 'usuario'])
        ->whereIn('usuario_id', $grupo->usuarios->pluck('id'))
        ->get();

    $respuestasCruzadas = RespuestaPorPares::with(['pregunta', 'usuario', 'evaluado'])
        ->whereIn('usuario_id', $grupo->usuarios->pluck('id'))
        ->get();

    // Pasar los datos a la vista
    return view('VistasDocentes.VistaGrupo.evaluaciones', [
        'grupo' => $grupo,
        'respuestasAutoevaluacion' => $respuestasAutoevaluacion,
        'respuestasCruzadas' => $respuestasCruzadas
    ]);
}

}
