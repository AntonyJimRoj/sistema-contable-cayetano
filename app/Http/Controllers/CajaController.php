<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;

class CajaController extends Controller
{
    public function index()
    {
        $cajas = Caja::orderBy('nombre')->get();
        return view('cajas.index', compact('cajas'));
    }

    public function create()
    {
        return view('cajas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'saldo' => 'required|numeric|min:0',
        ]);

        Caja::create([
            'nombre' => $request->nombre,
            'saldo' => $request->saldo,
        ]);

        return redirect()->route('cajas.index')->with('success', 'Caja registrada correctamente ✅');
    }

    public function toggle($id)
    {
        $caja = Caja::findOrFail($id);
        $caja->estado = !$caja->estado;
        $caja->save();

        return back()->with('success', 'Estado de caja actualizado ✅');
    }
}
