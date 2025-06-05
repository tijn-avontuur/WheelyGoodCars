<form method="GET" action="{{ route('cars.rdw') }}">
    <input type="text" name="kenteken" value="{{ $licensePlate ?? '' }}" placeholder="Kenteken">
    <button type="submit">Zoek</button>
</form>

@if(!empty($carData))
    <h2>RDW Data:</h2>
    <pre>{{ print_r($carData, true) }}</pre>
@endif
