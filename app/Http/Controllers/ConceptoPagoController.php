<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConceptoPago;


class ConceptoPagoController extends Controller
{
   public function index()
    {
        $conceptos = ConceptoPago::orderBy('nombre')->get();
        return view('conceptos.index', compact('conceptos'));
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        ConceptoPago::create(['nombre' => $request->nombre, 'estado' => true]);
        return back()->with('success', 'Concepto creado ✅');
    }

    public function toggle($id)
    {
        $concepto = ConceptoPago::findOrFail($id);
        $concepto->estado = !$concepto->estado;
        $concepto->save();
        return back()->with('success', 'Estado actualizado ✅');
    }
}
