<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Estudiante;
use App\Models\ConceptoPago;
use App\Models\MedioPago;
use App\Models\Caja;

class IngresoController extends Controller
{
    // Método para listar ingresos con filtros opcionales
    public function index(Request $request)
    {
        // Consulta con relaciones precargadas
        $ingresos = Ingreso::with(['estudiante', 'concepto', 'medioPago', 'caja', 'usuario'])
            // Filtro por nombre de estudiante si se envió
            ->when($request->filled('nombre_estudiante'), function ($query) use ($request) {
                $query->whereHas('estudiante', function ($q) use ($request) {
                    $q->where('nombre', 'like', '%' . $request->nombre_estudiante . '%');
                });
            })
            // Filtro por fecha mínima
            ->when($request->filled('desde'), function ($query) use ($request) {
                $query->whereDate('fecha_pago', '>=', $request->desde);
            })
            // Filtro por fecha máxima
            ->when($request->filled('hasta'), function ($query) use ($request) {
                $query->whereDate('fecha_pago', '<=', $request->hasta);
            })
            // Orden descendente por fecha de pago
            ->orderByDesc('fecha_pago')
            ->paginate(10);

        // Obtener todos los estudiantes para filtro en la vista
        $estudiantes = Estudiante::all();

        return view('ingresos.index', compact('ingresos', 'estudiantes'));
    }

    // Método para mostrar el formulario de creación de un ingreso
    public function create()
    {
        return view('ingresos.create', [
            'estudiantes' => Estudiante::all(),
            'conceptos' => ConceptoPago::where('estado', true)->get(),
            'medios' => MedioPago::where('estado', true)->get(),
            'cajas' => Caja::all(),
        ]);
    }

    // Método para almacenar un nuevo ingreso
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'estudiante_id'   => 'required|exists:estudiantes,id',
            'concepto_id'     => 'required|exists:conceptos_pago,id',
            'monto'           => 'required|numeric|min:0.01',
            'medio_pago_id'   => 'required|exists:medios_pago,id',
            'caja_id'         => 'required|exists:cajas,id',
            'codigo_boleta'   => 'nullable|string|max:50',
            'imagen_boleta'   => 'nullable|image|max:2048', // imagen opcional, máx 2MB
        ]);

        // Subir imagen si fue cargada, usando operador null-safe
        $imagenPath = $request->file('imagen_boleta')?->store('boletas', 'public');

        // Crear nuevo registro de ingreso
        $ingreso = Ingreso::create([
            'estudiante_id'  => $validated['estudiante_id'],
            'concepto_id'    => $validated['concepto_id'],
            'monto'          => $validated['monto'],
            'medio_pago_id'  => $validated['medio_pago_id'],
            'fecha_pago'     => now(), // Fecha actual
            'caja_id'        => $validated['caja_id'],
            'codigo_boleta'  => $validated['codigo_boleta'],
            'imagen_boleta'  => $imagenPath,
            'usuario_id'     => Auth::id(), // ID del usuario autenticado
        ]);

        // Sumar el monto al saldo de la caja correspondiente
        Caja::where('id', $validated['caja_id'])->increment('saldo', $validated['monto']);

        // Redirigir con mensaje de éxito
        return redirect()->route('ingresos.create')->with('success', 'Ingreso registrado correctamente ✅');
    }
}

