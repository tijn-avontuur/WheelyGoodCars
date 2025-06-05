<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\RDWController;

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

// Car routes
Route::get('/cars', [CreateController::class, 'index'])->name('cars.index');
Route::get('/cars/create', [CreateController::class, 'create'])->name('cars.create');
Route::post('/cars', [CreateController::class, 'store'])->name('cars.store');
Route::get('/cars/mine', [CreateController::class, 'mine'])->middleware('auth')->name('cars.mine');
Route::get('/cars/{id}', [CreateController::class, 'show'])->name('cars.show');
Route::get('/cars/{id}/edit', [CreateController::class, 'edit'])->name('cars.edit');
Route::put('/cars/{id}', [CreateController::class, 'update'])->name('cars.update');
Route::delete('/cars/{id}', [CreateController::class, 'destroy'])->name('cars.destroy');

Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');

Route::get('/cars/rdw', [RDWController::class, 'showRdwData'])->name('cars.rdw');

require __DIR__.'/auth.php';