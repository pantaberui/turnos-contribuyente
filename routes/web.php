<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\AsesoriaConsulta;
use App\Http\Controllers\Reportes\DocumentoReporteAsesorFiscalController;
use App\Http\Controllers\Reportes\DocumentoReporteGeneralAsesoresController;

use Spatie\Browsershot\Browsershot;

Route::get('/reportes/pdf-test', function () {
    return response(
        Browsershot::html('<h1>PDF de prueba</h1><p>Browsershot funcionando.</p>')
            ->format('Letter')
            ->pdf()
    )->header('Content-Type', 'application/pdf');
})->middleware(['auth', 'role:Administrador']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/display-turnos', function () {
    return view('display.index');
})->name('display.turnos');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/reportes/debug', \App\Livewire\Reportes\DebugReporte::class)
//     ->name('reportes.debug');



/*
/*
|--------------------------------------------------------------------------
| Rutas para Administrador y Orientador Fiscal
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Rutas para Administrador y Orientador Fiscal
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Administrador|Orientador Fiscal'])->group(function () {
    Route::get('/recepcion', function () {
        return view('recepcion.index');
    })->name('recepcion.index');

    Route::get('/turnos', function () {
        return view('turnos.index');
    })->name('turnos.index');

    Route::get('/turnos/{turno}/ticket', function (\App\Models\Turno $turno) {
        return view('turnos.ticket', compact('turno'));
    })->name('turnos.ticket');

    Route::get('/contribuyentes', function () {
        return view('contribuyentes.index');
    })->name('contribuyentes.index');

    Route::get('/contribuyentes/create', function () {
        return view('contribuyentes.create');
    })->name('contribuyentes.create');

    Route::get('/contribuyentes/{contribuyente}/edit', function (\App\Models\Contribuyente $contribuyente) {
        return view('contribuyentes.edit', compact('contribuyente'));
    })->name('contribuyentes.edit');

    Route::get('/contribuyentes/{contribuyente}', function (\App\Models\Contribuyente $contribuyente) {
        return view('contribuyentes.show', compact('contribuyente'));
    })->name('contribuyentes.show');
});

/*
|--------------------------------------------------------------------------
| Rutas para Administrador y Asesor Fiscal
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Administrador|Asesor Fiscal'])->group(function () {
    Route::get('/asesoria', function () {
        return view('asesoria.index');
    })->name('asesoria.index');

    Route::get('/asesorias/consulta', AsesoriaConsulta::class)
        ->name('asesorias.consulta');
});

Route::get('/reportes/general-asesores/documento', [DocumentoReporteGeneralAsesoresController::class, 'index'])
    ->middleware(['auth', 'role:Administrador'])
    ->name('reportes.general-asesores.documento');

Route::get('/reportes/general-asesores/pdf', [DocumentoReporteGeneralAsesoresController::class, 'pdf'])
    ->middleware(['auth', 'role:Administrador'])
    ->name('reportes.general-asesores.pdf');

/*
|--------------------------------------------------------------------------
| Rutas solo Administrador
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/catalogos/tipo-tramites', function () {
        return view('catalogos.tipo-tramites.index');
    })->name('catalogos.tipo-tramites.index');

    Route::get('/catalogos/clasificacion-tramites', function () {
        return view('catalogos.clasificacion_tramites.index');
    })->name('catalogos.clasificacion-tramites.index');

    Route::get('/catalogos/tramites', function () {
        return view('catalogos.tramites.index');
    })->name('catalogos.tramites.index');

    Route::get('/catalogos/modulos-asesoria', function () {
        return view('catalogos.modulos_asesoria.index');
    })->name('catalogos.modulos-asesoria.index');

    Route::get('/catalogos/usuarios', function () {
        return view('catalogos.usuarios.index');
    })->name('catalogos.usuarios.index');

    Route::get('/reportes/asesor-fiscal/pdf', [DocumentoReporteAsesorFiscalController::class, 'pdf'])
        ->middleware(['auth', 'role:Administrador'])
        ->name('reportes.asesor-fiscal.pdf');

    // Route::get('/reportes/prueba', \App\Livewire\Reportes\ReportePrueba::class)
    //    ->name('reportes.prueba');

});


Route::get('/reportes/asesor-fiscal/documento', [DocumentoReporteAsesorFiscalController::class, 'index'])
    ->middleware(['auth', 'role:Administrador'])
    ->name('reportes.asesor-fiscal.documento');

/*
|--------------------------------------------------------------------------
| Perfil
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';