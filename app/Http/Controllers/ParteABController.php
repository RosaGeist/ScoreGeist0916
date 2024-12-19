<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParteABController extends Controller
{
    // public function index()
    // {
    //     return view('tareas.index'); // Asegúrate de que la vista existe
    // }

    public function store(Request $request)
    {
        // Validar los archivos para Parte A y Parte B
        $request->validate([
            'parte_a' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:2048',
            'parte_b' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:2048',
        ]);

        // Guardar los archivos
        $pathParteA = $request->file('parte_a')->store('tareas/parte_a');
        $pathParteB = $request->file('parte_b')->store('tareas/parte_b');

        // Aquí puedes agregar lógica adicional, como guardar la información en la base de datos

        return redirect()->route('tareas.index')->with('success', 'Tareas subidas correctamente');
    }
}

