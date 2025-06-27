<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConceptoPago;

class ConceptoPagoController extends Controller
{
    /**
     * Muestra la lista de conceptos de pago.
     */
    public function index()
    {
        $conceptos = ConceptoPago::orderBy('nombre')->get();

        return view('conceptos.index', compact('conceptos'));
    }

    /**
     * Almacena un nuevo concepto de pago.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
        ]);

        ConceptoPago::create([
            'nombre' => $validated['nombre'],
            'estado' => true,
        ]);

        return back()->with('success', 'Concepto creado ✅');
    }

    /**
     * Cambia el estado activo/inactivo del concepto.
     */
    public function toggle($id)
    {
        $concepto = ConceptoPago::findOrFail($id);

        $concepto->estado = !$concepto->estado;
        $concepto->save();

        return back()->with('success', 'Estado actualizado ✅');
    }
}
