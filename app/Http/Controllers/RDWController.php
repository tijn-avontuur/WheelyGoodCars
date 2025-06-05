<?php

namespace App\Http\Controllers;

use App\Services\RDWApiService;
use Illuminate\Http\Request;

class RDWController extends Controller
{
    protected RDWApiService $rdwService;

    public function __construct(RDWApiService $rdwService)
    {
        $this->rdwService = $rdwService;
    }

    public function search(Request $request)
    {
        $kenteken = $request->input('kenteken');
        $data = $this->rdwService->getVehicleByLicensePlate($kenteken);

        // Return data as JSON response
        return response()->json($data);
    }

      // licenseplate 
    public function showRdwData(Request $request)
    {
        $licensePlate = $request->input('kenteken', '1-XXD-48'); 
        $rdwService = new RdwApiService();
        $carData = $rdwService->getCarByLicensePlate($licensePlate);

        return view('cars.rdw', compact('carData', 'licensePlate'));
    }
}
