<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Egreso;
use App\Models\Caja;

class EgresoController extends Controller
{

    public function index(Request $request)
    {
        $query = Egreso::with(['caja', 'usuario']);

        // Filtro por concepto (busca coincidencias en el texto)
        if ($request->filled('concepto')) {
            $query->where('concepto_egreso', 'like', '%' . $request->concepto . '%');
        }

        // Filtro por caja
        if ($request->filled('caja_id')) {
            $query->where('caja_id', $request->caja_id);
        }

        // Filtro por fecha desde
        if ($request->filled('desde')) {
            $query->whereDate('fecha_egreso', '>=', $request->desde);
        }

        // Filtro por fecha hasta
        if ($request->filled('hasta')) {
            $query->whereDate('fecha_egreso', '<=', $request->hasta);
        }

        $egresos = $query->orderBy('fecha_egreso', 'desc')->paginate(10);
        $cajas = \App\Models\Caja::all();

        return view('egresos.index', compact('egresos', 'cajas'));
    }


    public function create()
    {
        $cajas = Caja::all();
        return view('egresos.create', compact('cajas'));
    }

    public function store(Request $request)
{
    // Validaciones
    $validated = $request->validate([
        'concepto_egreso' => 'required|string|max:200',
        'monto' => 'required|numeric|min:0.01',
        'caja_id' => 'required|exists:cajas,id',
        'imagen_recibo' => 'nullable|image|max:2048', // max 2MB
    ]);

    // Verificar saldo de caja
    $caja = Caja::findOrFail($validated['caja_id']);

    if ($validated['monto'] > $caja->saldo) {
        return back()->withErrors(['monto' => 'La caja seleccionada no tiene suficiente saldo.'])->withInput();
    }

    // Subir imagen (si la hay)
    $imagenPath = null;
    if ($request->hasFile('imagen_recibo')) {
        $imagenPath = $request->file('imagen_recibo')->store('egresos', 'public');
    }

    // Crear egreso
    Egreso::create([
        'concepto_egreso' => $validated['concepto_egreso'],
        'monto' => $validated['monto'],
        'fecha_egreso' => now(),
        'caja_id' => $validated['caja_id'],
        'imagen_recibo' => $imagenPath,
        'usuario_id' => Auth::id(),
    ]);

    // Actualizar saldo de la caja
    $caja->saldo -= $validated['monto'];
    $caja->save();

    return redirect()->route('egresos.create')->with('success', 'Egreso registrado correctamente ✅');
}

}
