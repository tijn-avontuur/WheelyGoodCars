@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nieuw aanbod</h2>

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="license_plate" class="form-label">Kenteken:</label>
            <input type="text" class="form-control @error('license_plate') is-invalid @enderror" id="license_plate" name="license_plate" placeholder="bijv. BZTL87" required>
            @error('license_plate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Vul het kenteken in om auto-informatie automatisch te laden (gebruik geen streepjes). Dit kan even duren.</small>
        </div>

        <div class="mb-3">
            <label for="brand" class="form-label">Merk:</label>
            <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" required>
            @error('brand')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model:</label>
            <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" required>
            @error('model')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="seats" class="form-label">Zitplaatsen:</label>
            <input type="number" class="form-control @error('seats') is-invalid @enderror" id="seats" name="seats" required>
            @error('seats')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="doors" class="form-label">Aantal deuren:</label>
            <input type="number" class="form-control @error('doors') is-invalid @enderror" id="doors" name="doors" required>
            @error('doors')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Massa rijklaar:</label>
            <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" required>
            @error('weight')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="production_year" class="form-label">Jaar van productie:</label>
            <input type="number" class="form-control @error('production_year') is-invalid @enderror" id="production_year" name="production_year" required>
            @error('production_year')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Kleur:</label>
            <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" required>
            @error('color')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mileage" class="form-label">Kilometerstand:</label>
            <div class="input-group">
                <input type="number" class="form-control @error('mileage') is-invalid @enderror" id="mileage" name="mileage" required>
                <span class="input-group-text">km</span>
                @error('mileage')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <small class="form-text text-muted">Kilometerstand wordt niet automatisch ingevuld.</small>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Vraagprijs:</label>
            <div class="input-group">
                <span class="input-group-text">€</span>
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Foto van de auto:</label>
            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
            @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
    const licensePlate = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
    console.log('Processing license plate: ' + licensePlate);

    if (!licensePlate.match(/^[A-Z0-9]{6}$/)) {
        alert('Vul een geldig kenteken in (6 tekens, letters en cijfers, geen streepjes, bijv. BZTL87).');
        return;
    }

    console.log('Sending fetch request to: {{ route("cars.rdw.search") }}?kenteken=' + encodeURIComponent(licensePlate));
    fetch('{{ route("cars.rdw.search") }}?kenteken=' + encodeURIComponent(licensePlate), {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        console.log('Fetch response status: ' + response.status);
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error('Network error or invalid response: ' + text);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Fetch response data: ', data);
        if (data && data.merk) {
            document.getElementById('brand').value = data.merk || '';
            document.getElementById('model').value = data.handelsbenaming || '';
            document.getElementById('color').value = data.kleur || '';
            document.getElementById('production_year').value = data.datum_eerste_toelating ? data.datum_eerste_toelating.substring(0, 4) : '';
            document.getElementById('seats').value = data.aantal_zitplaatsen || '';
            document.getElementById('doors').value = data.aantal_deuren || '';
            document.getElementById('weight').value = data.massa_rijklaar || '';
        } else {
            alert(data.error || 'Geen gegevens gevonden voor dit kenteken.');
        }
    })
    .catch(error => {
        console.error('Fetch error details: ', error);
        alert('Er ging iets mis bij het ophalen van de kentekengegevens: ' + error.message);
    });
});
</script>
@endsection
@endsection