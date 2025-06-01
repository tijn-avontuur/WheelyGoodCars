@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Alle auto's</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($cars->isEmpty())
        <p>Geen auto's beschikbaar.</p>
    @else
        <form method="GET" action="{{ route('cars.index') }}" class="mb-4">
            <button class="btn btn-outline-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#filterTagsCollapse" aria-expanded="false" aria-controls="filterTagsCollapse">
                Filter op tags
            </button>
            <div class="collapse" id="filterTagsCollapse">
                <div class="card card-body mb-2">
                    @foreach($tags as $tag)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tags[]" id="filter_tag{{ $tag->id }}" value="{{ $tag->id }}"
                                @if(request()->has('tags') && in_array($tag->id, request('tags', []))) checked @endif>
                            <label class="form-check-label" for="filter_tag{{ $tag->id }}" style="color: {{ $tag->color }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Kenteken</th>
                    <th>Zitplaatsen</th>
                    <th>Deuren</th>
                    <th>Gewicht</th>
                    <th>Bouwjaar</th>
                    <th>Kleur</th>
                    <th>Kilometerstand</th>
                    <th>Tags</th>
                    <th>Prijs</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cars as $car)
                    <tr>
                        <td>{{ $car->brand }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->license_plate }}</td>
                        <td>{{ $car->seats }}</td>
                        <td>{{ $car->doors }}</td>
                        <td>{{ $car->weight }} kg</td>
                        <td>{{ $car->production_year }}</td>
                        <td>{{ $car->color }}</td>
                        <td>{{ $car->mileage }} km</td>
                        <td>
                            @forelse($car->tags as $tag)
                                <span class="badge" style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                            @empty
                                <span class="text-muted">Geen tags</span>
                            @endforelse
                        </td>
                        <td>€{{ number_format($car->price, 2) }}</td>
                        <td>
                            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-info btn-sm">Bekijk</a>
                            @if (Auth::id() === $car->user_id)
                                <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning btn-sm">Bewerk</a>
                                <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze auto wilt verwijderen?')">Verwijder</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection