<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CocktailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
});

Route::get('/', [CocktailController::class, 'index']);
Route::get('/cocktails', [CocktailController::class, 'index']);
Route::post('/cocktails', [CocktailController::class, 'store']);
Route::get('/cocktails/show', [CocktailController::class, 'showCocktails'])->name('cocktails.show');
Route::get('/cocktails/{id}/edit', [CocktailController::class, 'edit']);
Route::put('/cocktails/{id}', [CocktailController::class, 'update']);
Route::delete('/cocktails/{id}', [CocktailController::class, 'destroy']);
Route::get('/cocktails/{idDrink}/details', [CocktailController::class, 'getCocktailDetails']);

require __DIR__.'/auth.php';
