<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;

class CreateController extends Controller
{
    public function index(Request $request)
    {
        $tags = \App\Models\Tag::all();
        $cars = \App\Models\Car::query()->where('status', 'available');

        if ($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $cars->where(function ($query) use ($search) {
                $query->where('brand', 'like', $search)
                    ->orWhere('model', 'like', $search);
            });
        }

        if ($request->has('tags')) {
            foreach ($request->input('tags') as $tagId) {
                $cars->whereHas('tags', function ($query) use ($tagId) {
                    $query->where('tags.id', $tagId);
                });
            }
        }

        $perPage = $request->input('per_page', 20);
        if ($perPage === 'all') {
            $perPage = 10000;
        }

        $cars = $cars->with('tags')->orderByDesc('created_at')->paginate((int)$perPage)->withQueryString();

        return view('cars.store', compact('cars', 'tags', 'perPage'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('cars.create', compact('tags'));
    }

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
            'license_plate' => 'required|string|regex:/^[A-Z0-9]{1,8}$/',
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
        $car->license_plate = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $validated['license_plate']));
        $car->status = 'available';

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

    public function show($id)
    {
        $car = Car::findOrFail($id);
        $car->increment('views');
        return view('cars.show', compact('car'));
    }

    public function mine()
    {
        $userId = Auth::id();
        $cars = Car::where('user_id', $userId)->get();

        return view('cars.mine', compact('cars'));
    }

    public function edit($id)
    {
        $car = Car::findOrFail($id);
        if ($car->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $tags = \App\Models\Tag::all();
        return view('cars.edit', compact('car', 'tags'));
    }

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
            'license_plate' => 'required|string|regex:/^[A-Z0-9]{1,8}$/',
            'status' => 'required|in:available,sold',
        ]);

        $validated['license_plate'] = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $validated['license_plate']));
        $car->update($validated);

        if ($request->has('tags')) {
            $car->tags()->sync($request->input('tags'));
        } else {
            $car->tags()->sync([]);
        }

        return redirect()->route('cars.index')->with('success', 'Auto succesvol bijgewerkt!');
    }

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