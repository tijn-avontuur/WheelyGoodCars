@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nieuw aanbod voor kenteken: {{ $car->license_plate }}</h2>

    <ul>
        <li>Merk: {{ $car->brand }}</li>
        <li>Model: {{ $car->model }}</li>
        <li>Zitplaatsen: {{ $car->seats }}</li>
        <li>Aantal deuren: {{ $car->doors }}</li>
        <li>Massa rijklaar: {{ $car->weight }} kg</li>
        <li>Jaar van productie: {{ $car->production_year }}</li>
        <li>Kleur: {{ $car->color }}</li>
        <li>Kilometerstand: {{ $car->mileage }} km</li>
        <li>Vraagprijs: €{{ number_format($car->price, 2) }}</li>
    </ul>
</div>
@endsection
