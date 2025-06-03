<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;

class CreateController extends Controller
{
    // Show all cars (index for store.blade.php)
    public function index(Request $request)
    {
        $tags = \App\Models\Tag::all();

        $cars = Car::query()->where('status', 'available'); // Only show available cars

        if ($request->has('tags')) {
            $cars->whereHas('tags', function ($query) use ($request) {
                $query->whereIn('tags.id', $request->input('tags'));
            });
        }

        $cars = $cars->get();

        return view('cars.store', compact('cars', 'tags'));
    }

    // Show the form for creating a new car
    public function create()
    {
        $tags = Tag::all();
        return view('cars.create', compact('tags'));
    }

    // Store a newly created car in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
            'doors' => 'required|integer|min:1',
            'weight' => 'required|integer|min:0',
            'production_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'mileage' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
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
        $car->license_plate = 'TBD';
        $car->status = 'available'; // Default status

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('car_photos', 'public');
            $car->image = $path;
        }

        $car->save();

        if ($request->has('tags')) {
            $car->tags()->sync($request->input('tags'));
        }

        return redirect()->route('cars.index')->with('success', 'Auto succesvol toegevoegd!');
    }

    // Show the details of a specific car
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('cars.show', compact('car'));
    }

    // Show cars owned by the logged-in user
    public function mine()
    {
        $userId = Auth::id();
        $cars = Car::where('user_id', $userId)->get();

        return view('cars.mine', compact('cars'));
    }

    // Show the form for editing a car
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        if ($car->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $tags = \App\Models\Tag::all();
        return view('cars.edit', compact('car', 'tags'));
    }

    // Update the car in the database
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        if ($car->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
            'doors' => 'required|integer|min:1',
            'weight' => 'required|integer|min:0',
            'production_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'mileage' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,sold', // Add status validation
        ]);

        $car->update($validated);

        if ($request->has('tags')) {
            $car->tags()->sync($request->input('tags'));
        } else {
            $car->tags()->sync([]);
        }

        return redirect()->route('cars.index')->with('success', 'Auto succesvol bijgewerkt!');
    }

    // Delete a car
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        if ($car->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $car->tags()->detach();
        if ($car->image) {
            \Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()->route('cars.mine')->with('success', 'Auto succesvol verwijderd!');
    }
}