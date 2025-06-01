@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Auto bewerken</h2>

    <form action="{{ route('cars.update', $car->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="brand" class="form-label">Merk:</label>
            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $car->brand) }}" required>
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model:</label>
            <input type="text" class="form-control" id="model" name="model" value="{{ old('model', $car->model) }}" required>
        </div>

        <div class="mb-3">
            <label for="seats" class="form-label">Zitplaatsen:</label>
            <input type="number" class="form-control" id="seats" name="seats" value="{{ old('seats', $car->seats) }}" required>
        </div>

        <div class="mb-3">
            <label for="doors" class="form-label">Aantal deuren:</label>
            <input type="number" class="form-control" id="doors" name="doors" value="{{ old('doors', $car->doors) }}" required>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Massa rijklaar:</label>
            <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight', $car->weight) }}" required>
        </div>

        <div class="mb-3">
            <label for="production_year" class="form-label">Jaar van productie:</label>
            <input type="number" class="form-control" id="production_year" name="production_year" value="{{ old('production_year', $car->production_year) }}" required>
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Kleur:</label>
            <input type="text" class="form-control" id="color" name="color" value="{{ old('color', $car->color) }}" required>
        </div>

        <div class="mb-3">
            <label for="mileage" class="form-label">Kilometerstand:</label>
            <div class="input-group">
                <input type="number" class="form-control" id="mileage" name="mileage" value="{{ old('mileage', $car->mileage) }}" required>
                <span class="input-group-text">km</span>
            </div>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Vraagprijs:</label>
            <div class="input-group">
                <span class="input-group-text">€</span>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $car->price) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tags:</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <div class="form-check" style="min-width: 150px;">
                        <input class="form-check-input" type="checkbox" name="tags[]" id="tag{{ $tag->id }}"
                            value="{{ $tag->id }}"
                            @if(in_array($tag->id, old('tags', $car->tags->pluck('id')->toArray()))) checked @endif>
                        <label class="form-check-label" for="tag{{ $tag->id }}" style="color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <small class="form-text text-muted">Selecteer één of meerdere tags.</small>
        </div>

        <button type="submit" class="btn btn-primary">Wijzigingen opslaan</button>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary">Annuleren</a>
    </form>
</div>
@endsection