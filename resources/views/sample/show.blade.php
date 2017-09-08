@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>{{ $sample->name }}</h3>

                <a class="btn btn-primary" href="{{ route('subject.create', ['id'=>$sample->id]) }}" role="button">New subject</a>

                <div class="panel-body">
                  <ul>
                      @foreach($sample->subjects as $subject)
                      <li>{{ $subject->id }} -> {{ $subject->name }}</li>
                      @endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
