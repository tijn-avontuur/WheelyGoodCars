@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nieuw aanbod</h2>
    
    <p>Hier komt de kenteken API</p>

    <div class="mb-3">
    <label for="license_plate" class="form-label">Kenteken:</label>
    <input type="text" class="form-control" id="license_plate" name="license_plate" placeholder="bijv. AB12CDE" required>
    <small class="form-text text-muted">Vul het kenteken in om auto-informatie automatisch te laden.</small>
</div>

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
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

        <div class="mb-3">
            <label for="photo" class="form-label">Foto van de auto:</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Tags:</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <div class="form-check" style="min-width: 150px;">
                        <input class="form-check-input" type="checkbox" name="tags[]" id="tag{{ $tag->id }}" value="{{ $tag->id }}">
                        <label class="form-check-label" for="tag{{ $tag->id }}" style="color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <small class="form-text text-muted">Selecteer één of meerdere tags.</small>
        </div>

        <button type="submit" class="btn btn-primary">Aanbod afronden</button>
    </form>
</div>

@section('scripts')
<script>
document.getElementById('license_plate').addEventListener('blur', function () {
    const licensePlate = this.value.replace(/\s+/g, '').toUpperCase();
    if (!licensePlate) return;

    fetch(`https://kentekenapi.com/${licensePlate}`) 
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('brand').value = data.data.brand || '';
                document.getElementById('model').value = data.data.model || '';
                document.getElementById('color').value = data.data.color || '';
                document.getElementById('production_year').value = data.data.year || '';
                document.getElementById('mileage').value = data.data.mileage || '';
                document.getElementById('seats').value = data.data.seats || '';
                document.getElementById('doors').value = data.data.doors || '';
            } else {
                alert('Geen gegevens gevonden voor dit kenteken.');
            }
        })
        .catch(error => {
            console.error('Fout:', error);
            alert('Er ging iets mis bij het ophalen van de kentekengegevens.');
        });
});
</script>
@endsection 
@endsection
