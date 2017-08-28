@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $sample->name }}</div>

                <a class="btn btn-primary" href="{{ route('entrie.create', $sample->id) }}" role="button">New entrie</a>

                <div class="panel-body">
                  <ul>
                      @foreach($sample->entries as $entrie)
                      <li>{{ $entrie->id }} -> {{ $entrie->name }}</li>
                      @endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
