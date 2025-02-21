@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nieuw aanbod</h2>
    
    <p>Hier komt de kenteken API</p>

    <form action="{{ route('cars.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="brand" class="form-label">Merk:</label>
            <input type="text" class="form-control" id="brand" name="brand" required>
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model:</label>
            <input type="text" class="form-control" id="model" name="model" required>
        </div>

        <div class="mb-3">
            <label for="seats" class="form-label">Zitplaatsen:</label>
            <input type="number" class="form-control" id="seats" name="seats" required>
        </div>

        <div class="mb-3">
            <label for="doors" class="form-label">Aantal deuren:</label>
            <input type="number" class="form-control" id="doors" name="doors" required>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Massa rijklaar:</label>
            <input type="number" class="form-control" id="weight" name="weight" required>
        </div>

        <div class="mb-3">
            <label for="production_year" class="form-label">Jaar van productie:</label>
            <input type="number" class="form-control" id="production_year" name="production_year" required>
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Kleur:</label>
            <input type="text" class="form-control" id="color" name="color" required>
        </div>

        <div class="mb-3">
            <label for="mileage" class="form-label">Kilometerstand:</label>
            <div class="input-group">
                <input type="number" class="form-control" id="mileage" name="mileage" required>
                <span class="input-group-text">km</span>
            </div>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Vraagprijs:</label>
            <div class="input-group">
                <span class="input-group-text">€</span>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Aanbod afronden</button>
    </form>
</div>
@endsection
