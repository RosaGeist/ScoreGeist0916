<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pregunta;

class PreguntaController extends Controller
{
    public function index()
    {
        $preguntas = Pregunta::all();
        $preguntasAgrupadas = $preguntas->groupBy('evaluacion');
        return view('VistasDocentes.preguntas', compact('preguntasAgrupadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'texto' => 'required|string|max:255',
            'tipo' => 'required|in:f/v,escala_1_5,respuesta_corta,opcion_multiple',
            'evaluacion' => 'required|in:autoevaluacion,cruzada,porpares',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Pregunta::create($request->all());
        return redirect()->route('preguntas.index')->with('success', 'Pregunta creada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'texto' => 'required|string|max:255',
            'tipo' => 'required|in:f/v,escala_1_5,respuesta_corta,opcion_multiple',
            'evaluacion' => 'required|in:autoevaluacion,cruzada,porpares',
            'estado' => 'required|in:activo,inactivo',
        ]);

        // Buscar la pregunta a actualizar
        $pregunta = Pregunta::findOrFail($id);

        // Actualizar los datos de la pregunta
        $pregunta->update($request->all());

        // Redirigir a la vista con un mensaje de éxito
        return redirect()->route('preguntas.index')->with('success', 'Pregunta actualizada exitosamente.');
    }


    public function destroy($id)
    {

        $pregunta = Pregunta::findOrFail($id);
        $pregunta->delete();
        return redirect()->route('preguntas.index')->with('success', 'Pregunta eliminada exitosamente.');
    }
}
