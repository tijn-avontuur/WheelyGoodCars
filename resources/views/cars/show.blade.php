@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Auto details</h2>
    
    <ul>
        <li><strong>Merk:</strong> {{ $car->brand }}</li>
        <li><strong>Model:</strong> {{ $car->model }}</li>
        <li><strong>Kenteken:</strong> {{ $car->license_plate }}</li>
        <li><strong>Zitplaatsen:</strong> {{ $car->seats }}</li>
        <li><strong>Aantal deuren:</strong> {{ $car->doors }}</li>
        <li><strong>Massa rijklaar:</strong> {{ $car->weight }} kg</li>
        <li><strong>Jaar van productie:</strong> {{ $car->production_year }}</li>
        <li><strong>Kleur:</strong> {{ $car->color }}</li>
        <li><strong>Kilometerstand:</strong> {{ $car->mileage }} km</li>
        <li><strong>Vraagprijs:</strong> €{{ number_format($car->price, 2) }}</li>
    </ul>

    @if (Auth::id() === $car->user_id)
        <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning btn-sm">Bewerk</a>
        <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze auto wilt verwijderen?')">Verwijder</button>
        </form>
    @endif

    <a href="{{ route('cars.index') }}" class="btn btn-secondary btn-sm">Terug naar alle auto's</a>
</div>
@endsection