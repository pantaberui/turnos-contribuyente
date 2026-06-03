<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/contribuyentes', function () {
    return view('contribuyentes.index');
})->middleware(['auth'])->name('contribuyentes.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/contribuyentes/create', function () {
    return view('contribuyentes.create');
})->middleware(['auth'])->name('contribuyentes.create');

Route::get('/contribuyentes/{contribuyente}/edit', function (\App\Models\Contribuyente $contribuyente) {
    return view('contribuyentes.edit', compact('contribuyente'));
})->middleware(['auth'])->name('contribuyentes.edit');

Route::get('/contribuyentes/{contribuyente}', function (\App\Models\Contribuyente $contribuyente) {
    return view('contribuyentes.show', compact('contribuyente'));
})->middleware(['auth'])->name('contribuyentes.show');

Route::get('/recepcion', function () {
    return view('recepcion.index');
})->middleware(['auth'])->name('recepcion.index');

Route::get('/turnos/{turno}/ticket', function (\App\Models\Turno $turno) {
    return view('turnos.ticket', compact('turno'));
})->middleware(['auth'])->name('turnos.ticket');

Route::get('/turnos', function () {
    return view('turnos.index');
})->middleware(['auth'])->name('turnos.index');

Route::get('/asesoria', function () {
    return view('asesoria.index');
})->middleware(['auth'])->name('asesoria.index');

Route::get('/catalogos/tipo-tramites', function () {
    return view('catalogos.tipo-tramites.index');
})->middleware(['auth'])->name('catalogos.tipo-tramites.index');

Route::get('/catalogos/clasificacion-tramites', function () {
    return view('catalogos.clasificacion_tramites.index');
})->middleware(['auth'])->name('catalogos.clasificacion-tramites.index');

Route::get('/catalogos/tramites', function () {
    return view('catalogos.tramites.index');
})->middleware(['auth'])->name('catalogos.tramites.index');

Route::get('/catalogos/modulos-asesoria', function () {
    return view('catalogos.modulos_asesoria.index');
})->middleware(['auth'])->name('catalogos.modulos-asesoria.index');

Route::get('/catalogos/usuarios', function () {
    return view('catalogos.usuarios.index');
})->middleware(['auth'])->name('catalogos.usuarios.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
