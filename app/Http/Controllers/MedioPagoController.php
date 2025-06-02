<?php

namespace App\Http\Controllers;

use App\Models\MedioPago;
use Illuminate\Http\Request;

class MedioPagoController extends Controller
{
    public function index()
    {
        $medios = MedioPago::orderBy('nombre')->get();
        return view('medios.index', compact('medios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        MedioPago::create([
            'nombre' => $request->nombre,
            'estado' => true,
        ]);

        return back()->with('success', 'Medio de pago agregado correctamente ✅');
    }

    public function toggle($id)
    {
        $medio = MedioPago::findOrFail($id);
        $medio->estado = !$medio->estado;
        $medio->save();

        return back()->with('success', 'Estado actualizado correctamente ✅');
    }
}
