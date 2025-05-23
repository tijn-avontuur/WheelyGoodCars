<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Services\RDWApiService;

Route::get('/rdw', function (RDWApiService $rdwApiService) {
    $kenteken = request('kenteken');
    
    if (!$kenteken) {
        return response()->json(['error' => 'Geen kenteken opgegeven']);
    }

    $vehicleData = $rdwApiService->getVehicleByLicensePlate($kenteken);

    if (isset($vehicleData['error'])) {
        return response()->json(['error' => $vehicleData['error']]);
    }

    return response()->json([
        'brand' => $vehicleData['merk'],
        'model' => $vehicleData['model'],
        'seats' => $vehicleData['zitplaatsen'],
        'doors' => $vehicleData['aantal_deuren'],
        'weight' => $vehicleData['massa_rijklaar'],
        'production_year' => $vehicleData['productiejaar'],
        'color' => $vehicleData['kleur'],
        'mileage' => $vehicleData['kilometerstand'],
    ]);
});

