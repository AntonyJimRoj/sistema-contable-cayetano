<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Estudiante;
use App\Models\ConceptoPago;
use App\Models\MedioPago;
use App\Models\Caja;

class IngresoController extends Controller
{
    public function index(Request $request)
    {
        $query = Ingreso::with(['estudiante', 'concepto', 'medioPago', 'caja', 'usuario']);

        // Filtro por nombre del estudiante
        if ($request->filled('nombre_estudiante')) {
            $query->whereHas('estudiante', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->nombre_estudiante . '%');
            });
        }

        // Filtro por fecha
        if ($request->filled('desde')) {
            $query->whereDate('fecha_pago', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha_pago', '<=', $request->hasta);
        }

        $ingresos = $query->orderBy('fecha_pago', 'desc')->paginate(10);

        $estudiantes = \App\Models\Estudiante::all();

        return view('ingresos.index', compact('ingresos', 'estudiantes'));
    }

    public function create()
    {
        $estudiantes = Estudiante::all();
        $conceptos = ConceptoPago::where('estado', true)->get();
        $medios = MedioPago::where('estado', true)->get();
        $cajas = Caja::all();

        return view('ingresos.create', compact('estudiantes', 'conceptos', 'medios', 'cajas'));
    }

    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'concepto_id' => 'required|exists:conceptos_pago,id',
            'monto' => 'required|numeric|min:0.01',
            'medio_pago_id' => 'required|exists:medios_pago,id',
            'caja_id' => 'required|exists:cajas,id',
            'codigo_boleta' => 'nullable|string|max:50',
            'imagen_boleta' => 'nullable|image|max:2048', // max 2MB
        ]);

        // Subir imagen si se cargó
        if ($request->hasFile('imagen_boleta')) {
            $imagenPath = $request->file('imagen_boleta')->store('boletas', 'public');
        } else {
            $imagenPath = null;
        }

        // Crear el ingreso
        $ingreso = Ingreso::create([
            'estudiante_id' => $validated['estudiante_id'],
            'concepto_id' => $validated['concepto_id'],
            'monto' => $validated['monto'],
            'medio_pago_id' => $validated['medio_pago_id'],
            'fecha_pago' => now(),
            'caja_id' => $validated['caja_id'],
            'codigo_boleta' => $validated['codigo_boleta'],
            'imagen_boleta' => $imagenPath,
            'usuario_id' => Auth::id(),
        ]);

        // Sumar al saldo de la caja
        $caja = Caja::find($validated['caja_id']);
        $caja->saldo += $validated['monto'];
        $caja->save();

        return redirect()->route('ingresos.create')->with('success', 'Ingreso registrado correctamente ✅');
    }

}
