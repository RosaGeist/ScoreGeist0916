<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Sprint;
use App\Models\RespuestaPorPares;

class RespuestaController extends Controller
{
    public function mostrarFormulario(Sprint $sprint)
    {
        $usuarioAutenticado = auth()->user();
    
        // Obtener las preguntas de tipo autoevaluación
        $preguntasAutoevaluacion = Pregunta::where('evaluacion', 'autoevaluacion')->get();
    
        // Obtener las preguntas de tipo porpares
        $preguntasPorPares = Pregunta::where('evaluacion', 'porpares')->get();
    
        // Respuestas del usuario autenticado para autoevaluación
        $respuestasUsuario = Respuesta::where('sprint_id', $sprint->id)
            ->where('usuario_id', $usuarioAutenticado->id)
            ->get();
    
        // Respuestas de evaluación por pares del usuario autenticado
        $respuestasEvaluacionPorPares = RespuestaPorPares::where('sprint_id', $sprint->id)
            ->where('usuario_id', $usuarioAutenticado->id)
            ->get();
    
        // Obtener el equipo del usuario
        $equipo = $usuarioAutenticado->equipos()->first();
    
        // Respuestas de los demás miembros del equipo para autoevaluación
        $respuestasMiembros = collect();
        if ($equipo) {
            $respuestasMiembros = Respuesta::where('sprint_id', $sprint->id)
                ->whereIn('usuario_id', $equipo->miembros->pluck('id'))
                ->where('usuario_id', '!=', $usuarioAutenticado->id)
                ->get()
                ->groupBy('usuario_id');
        }
    
        // Respuestas de evaluación por pares de los miembros del equipo (quiénes los evaluaron)
        $respuestasEvaluacionPorParesMiembros = collect();
        if ($equipo) {
            $respuestasEvaluacionPorParesMiembros = RespuestaPorPares::where('sprint_id', $sprint->id)
                ->whereIn('evaluado_id', $equipo->miembros->pluck('id')) // Aquí usamos evaluado_id
                ->get()
                ->groupBy('evaluado_id');
        }
    
        return view('VistasEstudiantes.formulario', compact(
            'sprint',
            'preguntasAutoevaluacion',
            'preguntasPorPares',
            'respuestasUsuario',
            'respuestasMiembros',
            'respuestasEvaluacionPorPares',
            'respuestasEvaluacionPorParesMiembros',
            'equipo'
        ));
    }
    

    public function guardarRespuestas(Request $request, Sprint $sprint)
    {
        // Verificar si el usuario ya ha respondido para este sprint
        $existeRespuesta = Respuesta::where('sprint_id', $sprint->id)
            ->where('usuario_id', auth()->id())
            ->exists();

        if ($existeRespuesta) {
            // Si ya existe una respuesta para este sprint, redirigir con un mensaje de error
            return redirect()->route('sprint-planner', $sprint->id)
                ->with('error', 'Ya has respondido a la autoevaluación de este sprint.');
        }

        // Validación de las respuestas
        $request->validate([
            'respuestas' => 'required|array',
            'respuestas.*' => 'required|string', // o 'required|integer' según el tipo de pregunta
        ]);

        // Guardar las respuestas
        foreach ($request->respuestas as $preguntaId => $respuesta) {
            Respuesta::create([
                'sprint_id' => $sprint->id,
                'usuario_id' => auth()->id(),
                'pregunta_id' => $preguntaId,
                'respuesta' => $respuesta,
            ]);
        }

        // Redirigir después de guardar las respuestas, sin permitir la edición
        return redirect()->route('sprint-planner', $sprint->id)
            ->with('success', 'Respuestas guardadas exitosamente.');
    }

    public function guardarEvaluacionPorPares(Request $request, Sprint $sprint)
    {
        // Validar que el usuario no haya evaluado a este miembro previamente
        foreach ($request->evaluaciones as $usuarioId => $evaluaciones) {
            foreach ($evaluaciones as $preguntaId => $respuesta) {
                // Verificar si ya existe una evaluación por este evaluador y para este miembro
                $evaluacionExistente = RespuestaPorPares::where('sprint_id', $sprint->id)
                    ->where('evaluador_id', auth()->id())
                    ->where('evaluado_id', $usuarioId)
                    ->where('pregunta_id', $preguntaId)
                    ->first();

                if ($evaluacionExistente) {
                    // Si ya existe, actualizar la respuesta
                    $evaluacionExistente->update(['respuesta' => $respuesta]);
                } else {
                    // Si no existe, crear una nueva respuesta
                    RespuestaPorPares::create([
                        'sprint_id' => $sprint->id,
                        'evaluador_id' => auth()->id(),
                        'evaluado_id' => $usuarioId,
                        'pregunta_id' => $preguntaId,
                        'respuesta' => $respuesta,
                    ]);
                }
            }
        }

        // Redirigir con éxito
        return redirect()->route('sprint-planner', $sprint->id)
            ->with('success', 'Evaluación guardada exitosamente.');
    }
}
