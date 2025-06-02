<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    ProfileController,
    IngresoController,
    EgresoController,
    EstudianteController,
    CursoController,
    ReporteController,
    UsuarioController,
    ConceptoPagoController,
    MedioPagoController,
    CajaController,
    AdminDashboardController,
    ContadorDashboardController,
    AyudanteDashboardController,
    ExportarReporteController,
    TwoFactorController
};

Route::get('/', fn () => view('welcome'));

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ingresos
    Route::resource('ingresos', IngresoController::class)->only(['index', 'create', 'store']);

    // Egresos
    Route::resource('egresos', EgresoController::class)->only(['index', 'create', 'store']);

    // Estudiantes y cursos
    Route::resource('estudiantes', EstudianteController::class)->only(['index', 'create', 'store']);
    Route::get('/estudiantes/{id}/cursos', [EstudianteController::class, 'cursos'])->name('estudiantes.cursos');
    Route::post('/estudiantes/{id}/cursos', [EstudianteController::class, 'asignarCursos'])->name('estudiantes.asignarCursos');

    // Cursos
    Route::resource('cursos', CursoController::class)->only(['index', 'create', 'store']);

    // Reporte Diario
    Route::get('/reportes/diario', [ReporteController::class, 'reporteDiario'])->name('reportes.diario');

    // 2FA personal
    Route::get('/2fa/enable', [TwoFactorController::class, 'enable2FA'])->name('2fa.enable');

    // Conceptos
    Route::resource('conceptos', ConceptoPagoController::class)->only(['index', 'store']);
    Route::put('/conceptos/{id}/toggle', [ConceptoPagoController::class, 'toggle'])->name('conceptos.toggle');

    // Medios de pago
    Route::resource('medios', MedioPagoController::class)->only(['index', 'store']);
    Route::put('/medios/{id}/toggle', [MedioPagoController::class, 'toggle'])->name('medios.toggle');

    // Cajas
    Route::resource('cajas', CajaController::class)->only(['index', 'create', 'store']);
    Route::put('/cajas/{id}/toggle', [CajaController::class, 'toggle'])->name('cajas.toggle');
});

// Reportes
Route::get('/reportes/mensual', [ReporteController::class, 'reporteMensual'])->name('reportes.mensual');
Route::get('/reportes/personalizado', [ReporteController::class, 'reportePersonalizado'])->name('reportes.personalizado');

// Dashboard con 2FA obligatorio
Route::get('/dashboard', function () {
    $user = Auth::user();
    return match ($user->rol_id) {
        1 => redirect()->route('dashboard.admin'),
        2 => redirect()->route('dashboard.contador'),
        3 => redirect()->route('dashboard.ayudante'),
        default => abort(403, 'Rol no válido'),
    };
})->middleware(['auth', 'check2fa'])->name('dashboard');

// Dashboards protegidos por 2FA
Route::get('/admin', [AdminDashboardController::class, 'adminDashboard'])
    ->middleware(['auth', 'check2fa', 'admin'])->name('dashboard.admin');

Route::get('/contador', [ContadorDashboardController::class, 'index'])
    ->middleware(['auth', 'check2fa'])->name('dashboard.contador');

Route::get('/ayudante', [AyudanteDashboardController::class, 'index'])
    ->middleware(['auth', 'check2fa'])->name('dashboard.ayudante');

// Exportaciones
Route::prefix('reportes')->group(function () {
    Route::get('/diario/pdf', [ExportarReporteController::class, 'exportarDiarioPDF'])->name('reportes.diario.pdf');
    Route::get('/diario/excel', [ExportarReporteController::class, 'exportarDiarioExcel'])->name('reportes.diario.excel');
    Route::get('/mensual/pdf', [ExportarReporteController::class, 'exportarMensualPDF'])->name('reportes.mensual.pdf');
    Route::get('/mensual/excel', [ExportarReporteController::class, 'exportarMensualExcel'])->name('reportes.mensual.excel');
    Route::get('/personalizado/pdf', [ExportarReporteController::class, 'exportarPersonalizadoPDF'])->name('reportes.personalizado.pdf');
    Route::get('/personalizado/excel', [ExportarReporteController::class, 'exportarPersonalizadoExcel'])->name('reportes.personalizado.excel');
});

// Validación 2FA
Route::get('/2fa/validate', [TwoFactorController::class, 'showValidateForm'])->name('2fa.validate');
Route::post('/2fa/validate', [TwoFactorController::class, 'verifyCode'])->name('2fa.verify');

// Activación/desactivación de 2FA por admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/usuarios/{id}/activar-2fa', [TwoFactorController::class, 'activarDesdeAdmin'])->name('admin.activar2fa');
    Route::put('/usuarios/{id}/desactivar-2fa', [TwoFactorController::class, 'desactivarDesdeAdmin'])->name('admin.desactivar2fa');
    Route::resource('usuarios', UsuarioController::class)->only(['index', 'create', 'store', 'edit', 'update']);
});

require __DIR__.'/auth.php';
