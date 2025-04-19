<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CocktailController;

// Ruta principal que muestra diferentes vistas según autenticación
Route::get('/', [CocktailController::class, 'index']);

// Ruta para el dashboard que ahora redirige a index
Route::get('/dashboard', function () {
    return redirect()->route('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cocktails/{idDrink}', [CocktailController::class, 'getCocktailDetails']);

// Ruta para la vista index
Route::get('/index', [CocktailController::class, 'index'])->name('index')->middleware('auth');

// Rutas de perfil (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/cocktails/save', [CocktailController::class, 'save'])->name('cocktails.save');
    Route::get('/cocktails/saved', [CocktailController::class, 'savedCocktails'])->name('cocktails.saved');
    Route::resource('cocktails', CocktailController::class)->except(['create', 'show']);
});

// Rutas de cócteles
Route::middleware('auth')->group(function () {
    Route::get('/cocktails', [CocktailController::class, 'index']);
    Route::post('/cocktails', [CocktailController::class, 'store']);
    Route::get('/cocktails/show', [CocktailController::class, 'showCocktails'])->name('cocktails.show');
    Route::get('/cocktails/{id}/edit', [CocktailController::class, 'edit']);
    Route::put('/cocktails/{id}', [CocktailController::class, 'update']);
    Route::delete('/cocktails/{id}', [CocktailController::class, 'destroy']);
});


Route::get('/cocktails/{idDrink}/details', [CocktailController::class, 'getCocktailDetails']);

require __DIR__ . '/auth.php';
