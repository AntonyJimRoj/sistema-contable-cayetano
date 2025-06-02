<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Rol;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }

    public function edit($id)
    {
        $usuario = \App\Models\Usuario::findOrFail($id);
        $roles = \App\Models\Rol::all();

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = \App\Models\Usuario::findOrFail($id);

        $validated = $request->validate([
            'nombre_usuario' => 'required|string|unique:usuarios,nombre_usuario,' . $usuario->id,
            'celular' => 'required|string|max:15',
            'rol_id' => 'required|exists:roles,id',
            'email' => 'nullable|email|max:100',
            'contraseña' => 'nullable|string|min:6',
        ]);

        $usuario->nombre_usuario = $validated['nombre_usuario'];
        $usuario->celular = $validated['celular'];
        $usuario->rol_id = $validated['rol_id'];
        $usuario->email = $validated['email'];

        if (!empty($validated['contraseña'])) {
            $usuario->contraseña = Hash::make($validated['contraseña']);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente ✅');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_usuario' => 'required|string|unique:usuarios,nombre_usuario',
            'contraseña' => 'required|string|min:6',
            'celular' => 'required|string|max:15',
            'rol_id' => 'required|exists:roles,id',
            'email' => 'nullable|email|max:100',
        ]);

        \App\Models\Usuario::create([
            'nombre_usuario' => $validated['nombre_usuario'],
            'contraseña' => Hash::make($validated['contraseña']),
            'celular' => $validated['celular'],
            'rol_id' => $validated['rol_id'],
            'email' => $validated['email'],
            'estado' => true,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente ✅');
    }

}
