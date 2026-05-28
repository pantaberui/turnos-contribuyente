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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
