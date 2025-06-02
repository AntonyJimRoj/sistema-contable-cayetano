<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;


class CursoController extends Controller
{

    public function index()
    {
        $cursos = Curso::withCount('estudiantes')->orderBy('nombre')->paginate(10);
        return view('cursos.index', compact('cursos'));
    }


    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        Curso::create($validated);

        return redirect()->route('cursos.index')->with('success', 'Curso creado correctamente ✅');
    }
}