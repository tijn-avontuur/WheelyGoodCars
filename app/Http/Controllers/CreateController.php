<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    // Laat het formulier zien
    public function create()
    {
        return view('cars.create');
    }

    // Sla de auto op in de database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'seats' => 'required|integer',
            'doors' => 'required|integer',
            'weight' => 'required|integer',
            'production_year' => 'required|integer',
            'color' => 'required|string',
            'mileage' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $car = new Car();
        $car->user_id = Auth::id();
        $car->brand = $validated['brand'];
        $car->model = $validated['model'];
        $car->seats = $validated['seats'];
        $car->doors = $validated['doors'];
        $car->weight = $validated['weight'];
        $car->production_year = $validated['production_year'];
        $car->color = $validated['color'];
        $car->mileage = $validated['mileage'];
        $car->price = $validated['price'];
        $car->license_plate = 'TBD'; // Placeholder voor kenteken
        $car->save();

        return redirect()->route('cars.show', $car->id);
    }

    // Toon de details van een auto
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('cars.show', compact('car'));
    }
}
