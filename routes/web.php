<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\RDWController;
use App\Http\Controllers\AdminDashboardController;

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

Route::get('/cars', [CreateController::class, 'index'])->name('cars.index');
Route::get('/cars/create', [CreateController::class, 'create'])->name('cars.create');
Route::post('/cars', [CreateController::class, 'store'])->name('cars.store');
Route::get('/cars/mine', [CreateController::class, 'mine'])->middleware('auth')->name('cars.mine');
Route::get('/cars/{id}', [CreateController::class, 'show'])->name('cars.show');
Route::get('/cars/{id}/edit', [CreateController::class, 'edit'])->name('cars.edit')->middleware('auth');
Route::put('/cars/{id}', [CreateController::class, 'update'])->name('cars.update')->middleware('auth');
Route::delete('/cars/{id}', [CreateController::class, 'destroy'])->name('cars.destroy');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/admin/dashboard/stats', [AdminDashboardController::class, 'stats'])->name('admin.dashboard.stats')->middleware('auth');

Route::get('/cars/rdw', [RDWController::class, 'showRdwData'])->name('cars.rdw');
Route::get('/cars/rdw/search', [RDWController::class, 'search'])->name('cars.rdw.search');

Route::get('/rdw/{plate}', function ($plate) {
    $plate = strtoupper(preg_replace('/[^A-Z0-9]/', '', $plate));

    // RDW API: https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=XX9999
    $response = Http::get('https://opendata.rdw.nl/resource/m9d7-ebf2.json', [
        'kenteken' => $plate
    ]);

    if ($response->ok() && count($response->json()) > 0) {
        $data = $response->json()[0];
        return response()->json([
            'brand' => $data['merk'] ?? null,
            'model' => $data['handelsbenaming'] ?? null,
            'seats' => $data['aantal_zitplaatsen'] ?? null,
            'doors' => $data['aantal_deuren'] ?? null,
            'weight' => $data['massa_rijklaar'] ?? null,
            'production_year' => isset($data['datum_eerste_toelating']) ? substr($data['datum_eerste_toelating'], 0, 4) : null,
            'color' => $data['eerste_kleur'] ?? null,
        ]);
    } else {
        return response()->json(['error' => 'Geen gegevens gevonden voor dit kenteken.'], 404);
    }
});

require __DIR__.'/auth.php';