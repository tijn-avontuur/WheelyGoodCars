<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RDWApiService
{
    protected string $baseUrl = 'https://opendata.rdw.nl/resource/m9d7-ebf2.json';
    protected string $appToken;

    public function __construct()
    {
        // Get the app token from the environment file
        $this->appToken = env('RDW_APP_TOKEN');
        
        // Log the app token for verification
        Log::debug('RDW App Token: ' . $this->appToken);
    }

    public function getVehicleByLicensePlate(string $kenteken)
    {
        // Check if the license plate is in a valid format
        if (!preg_match('/^[A-Z0-9]{6}$/', $kenteken)) {
            return ['error' => 'Invalid license plate format'];
        }

        // Make the GET request to the RDW API with the license plate and App Token
        $response = Http::get($this->baseUrl, [
            'kenteken' => $kenteken,
            '$$app_token' => $this->appToken,  // Use the token
        ]);

        // Check if the API call was successful
        if ($response->successful()) {
            return $response->json();
        }

        // If the request failed, return an error message
        if ($response->failed()) {
            return ['error' => 'Error retrieving data for license plate ' . $kenteken];
        }

        return null;
    }
}
