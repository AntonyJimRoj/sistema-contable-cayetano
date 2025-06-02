<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Estudiante;

class EstudianteController extends Controller
{

    public function index()
    {
        $estudiantes = \App\Models\Estudiante::orderBy('nombre')->paginate(10);
        return view('estudiantes.index', compact('estudiantes'));
    }


    public function create()
    {
        return view('estudiantes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'dni' => 'nullable|string|max:15',
            'celular' => 'nullable|string|max:15',
        ]);

        Estudiante::create($validated);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante registrado correctamente ✅');
    }

    public function cursos($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $cursos = Curso::all();
        $cursosAsignados = $estudiante->cursos->pluck('id')->toArray();

        return view('estudiantes.cursos', compact('estudiante', 'cursos', 'cursosAsignados'));
    }

    public function asignarCursos(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $request->validate([
            'cursos' => 'nullable|array',
            'cursos.*' => 'exists:cursos,id',
        ]);

        $estudiante->cursos()->sync($request->cursos ?? []);

        return redirect()->route('estudiantes.index')->with('success', 'Cursos asignados correctamente ✅');
    }


}

