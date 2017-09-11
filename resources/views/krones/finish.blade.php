@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pesquisa Finalizada em {{ $finish }}</h2>

    <a href="{{ route('form.index', $survey->id) }}" class="btn btn-primary">Ir para pesquisa</a>
</div>
@endsection
