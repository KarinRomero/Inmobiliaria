<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\AuditoriaController; // <-- Línea agregada
use Illuminate\Support\Facades\Route;

Route::redirect('/dashoboard', '/propiedades')->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Recurso completo menos destroy: ADMINISTRADOR y OPERARIO pueden usar todo

    Route::resource('propiedades', PropiedadController::class)
        ->parameters(['propiedades' => 'propiedad'])
        ->except(['destroy']);

    // Destroy solo para ADMINISTRADOR
    Route::delete('propiedades/{propiedad}', [PropiedadController::class, 'destroy'])
        ->name('propiedades.destroy')
        ->middleware('admin');

    // Auditorías solo para ADMINISTRADOR <-- Bloque agregado
    Route::get('/auditorias', [AuditoriaController::class, 'index'])
        ->name('auditorias.index')
        ->middleware('admin');
});

require __DIR__.'/auth.php';