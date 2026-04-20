<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropiedadController; 
use Illuminate\Support\Facades\Route;

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
});

require __DIR__.'/auth.php';