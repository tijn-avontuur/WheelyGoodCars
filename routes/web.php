<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/cars/create', function () {
    return view('cars.create');
})->name('cars.create');

Route::middleware('auth')->group(function () {
    //
});

require __DIR__.'/auth.php';

use App\Http\Controllers\RDWController;

Route::get('/rdw', [RDWController::class, 'search']);
