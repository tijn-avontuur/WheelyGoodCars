@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Beheerder Dashboard</h2>
    <button class="btn btn-outline-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#tagsOverviewCollapse" aria-expanded="false" aria-controls="tagsOverviewCollapse">
        Tags Overzicht tonen/verbergen
    </button>
    <div class="collapse" id="tagsOverviewCollapse">
        <table class="table">
            <thead>
                <tr>
                    <th>Tag</th>
                    <th>Kleur</th>
                    <th>Totaal gebruikt</th>
                    <th>Bij beschikbare auto's</th>
                    <th>Bij verkochte auto's</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td><span class="badge" style="background: {{ $tag->color }}">{{ $tag->color }}</span></td>
                        <td>{{ $tag->cars_count }}</td>
                        <td>{{ $tag->available_count }}</td>
                        <td>{{ $tag->sold_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection