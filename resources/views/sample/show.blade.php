@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>{{ $sample->name }}</h3>

                <a class="btn btn-primary" href="{{ route('entrie.create', ['id'=>$sample->id]) }}" role="button">New entrie</a>

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
