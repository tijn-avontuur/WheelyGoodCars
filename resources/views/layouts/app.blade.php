@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nieuw aanbod</h2>
    
    <p>Hier komt de kenteken API</p>

    <form action="{{ route('cars.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="license_plate" class="form-label">Kenteken:</label>
            <input type="text" class="form-control" id="license_plate" name="license_plate" required>
        </div>

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

<script>
document.getElementById('license_plate').addEventListener('input', function() {
    let kenteken = this.value;
    
    // Voer een API-aanroep uit als het kenteken niet leeg is en minimaal 6 tekens heeft
    if (kenteken.length === 6) {
        fetch(`/api/rdw?kenteken=${kenteken}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Vul de velden met de gegevens van de API
                    document.getElementById('brand').value = data.brand || '';
                    document.getElementById('model').value = data.model || '';
                    document.getElementById('seats').value = data.seats || '';
                    document.getElementById('doors').value = data.doors || '';
                    document.getElementById('weight').value = data.weight || '';
                    document.getElementById('production_year').value = data.production_year || '';
                    document.getElementById('color').value = data.color || '';
                    document.getElementById('mileage').value = data.mileage || '';
                }
            })
            .catch(error => console.error('Error:', error));
    }
});
</script>
@endsection
