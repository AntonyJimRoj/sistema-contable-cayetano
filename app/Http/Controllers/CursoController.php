<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    /**
     * Muestra una lista paginada de cursos con la cantidad de estudiantes.
     */
    public function index()
    {
        $cursos = Curso::withCount('estudiantes')
                       ->orderBy('nombre')
                       ->paginate(10);

        return view('cursos.index', compact('cursos'));
    }

    /**
     * Muestra el formulario para crear un nuevo curso.
     */
    public function create()
    {
        return view('cursos.create');
    }

    /**
     * Guarda un nuevo curso en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
        ]);

        Curso::create($validated);

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso creado correctamente ✅');
    }
}
