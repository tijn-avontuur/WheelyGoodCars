@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mijn aanbod</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($cars->isEmpty())
        <p>Je hebt nog geen auto's toegevoegd.</p>
    @else
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
                            <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning btn-sm">Bewerk</a>
                            <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze auto wilt verwijderen?')">Verwijder</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection