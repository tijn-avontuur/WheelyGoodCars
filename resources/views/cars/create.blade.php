@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Voeg een auto toe</h2>
    <form action="{{ route('cars.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="merk" class="form-label">Merk:</label>
            <input type="text" class="form-control" id="merk" name="merk" required>
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model:</label>
            <input type="text" class="form-control" id="model" name="model" required>
        </div>

        <div class="mb-3">
            <label for="zitplaatsen" class="form-label">Zitplaatsen:</label>
            <input type="number" class="form-control" id="zitplaatsen" name="zitplaatsen" required>
        </div>

        <div class="mb-3">
            <label for="deuren" class="form-label">Aantal deuren:</label>
            <input type="number" class="form-control" id="deuren" name="deuren" required>
        </div>

        <div class="mb-3">
            <label for="massa" class="form-label">Massa rijklaar:</label>
            <input type="number" class="form-control" id="massa" name="massa" required>
        </div>

        <div class="mb-3">
            <label for="jaar" class="form-label">Jaar van productie:</label>
            <input type="number" class="form-control" id="jaar" name="jaar" required>
        </div>

        <div class="mb-3">
            <label for="kleur" class="form-label">Kleur:</label>
            <input type="text" class="form-control" id="kleur" name="kleur" required>
        </div>

        <div class="mb-3">
            <label for="kilometerafstand" class="form-label">Kilometerafstand:</label>
            <div class="input-group">
                <input type="number" class="form-control" id="kilometerafstand" name="kilometerafstand" required>
                <span class="input-group-text">km</span>
            </div>
        </div>

        <div class="mb-3">
            <label for="vraagprijs" class="form-label">Vraagprijs:</label>
            <div class="input-group">
                <span class="input-group-text">€</span>
                <input type="number" step="0.01" class="form-control" id="vraagprijs" name="vraagprijs" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Aanbod afronden</button>
    </form>
</div>
@endsection
