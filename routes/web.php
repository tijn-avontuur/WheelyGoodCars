<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreateController;

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
})->name('home');


Route::get('/cars/create', [CreateController::class, 'create'])->name('cars.create');
Route::post('/cars', [CreateController::class, 'store'])->name('cars.store');
Route::get('/cars/{id}', [CreateController::class, 'show'])->name('cars.show');

Route::middleware('auth')->group(function () {
    //
});

require __DIR__.'/auth.php';

use App\Http\Controllers\RDWController;

Route::get('/rdw', [RDWController::class, 'search']);
